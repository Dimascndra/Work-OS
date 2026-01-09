<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DnsCheckerController extends Controller
{
    public function index()
    {
        return view('pages.dns-checker.index');
    }

    public function check(Request $request)
    {
        $request->validate([
            'domain' => 'required|string',
            'type' => 'required|in:A,AAAA,MX,CNAME,NS,TXT,PTR,SOA',
        ]);

        $domain = $request->input('domain');
        // Remove protocols
        $domain = preg_replace('#^https?://#', '', $domain);
        $domain = rtrim($domain, '/');

        $type = $request->input('type');

        $results = [];

        // 1. Local System DNS
        $results['local'] = $this->checkLocal($domain, $type);

        // 2. Google DNS (DoH)
        $results['google'] = $this->checkGoogle($domain, $type);

        // 3. Cloudflare DNS (DoH)
        $results['cloudflare'] = $this->checkCloudflare($domain, $type);

        return back()->with('results', $results)->withInput();
    }

    private function checkLocal($domain, $type)
    {
        try {
            // Map string type to PHP constant
            $const = constant("DNS_" . $type);
            $records = dns_get_record($domain, $const);

            if (!$records) return ['status' => 'empty', 'data' => []];

            $data = [];
            foreach ($records as $r) {
                // Extract relevant value based on type
                $val = $this->extractValue($r, $type);
                if ($val) $data[] = $val;
            }
            sort($data);

            return ['status' => 'success', 'data' => $data];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    private function checkGoogle($domain, $type)
    {
        try {
            $response = Http::get("https://dns.google/resolve", [
                'name' => $domain,
                'type' => $type
            ]);

            if ($response->successful()) {
                $json = $response->json();
                if (isset($json['Answer'])) {
                    $data = array_map(function ($a) {
                        return $a['data'];
                    }, $json['Answer']);
                    sort($data);
                    return ['status' => 'success', 'data' => $data];
                }
                return ['status' => 'empty', 'data' => []];
            }
            return ['status' => 'error', 'message' => 'API Error: ' . $response->status()];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    private function checkCloudflare($domain, $type)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/dns-json'
            ])->get("https://cloudflare-dns.com/dns-query", [
                'name' => $domain,
                'type' => $type
            ]);

            if ($response->successful()) {
                $json = $response->json();
                if (isset($json['Answer'])) {
                    $data = array_map(function ($a) {
                        return $a['data'];
                    }, $json['Answer']);
                    sort($data);
                    return ['status' => 'success', 'data' => $data];
                }
                return ['status' => 'empty', 'data' => []];
            }
            return ['status' => 'error', 'message' => 'API Error: ' . $response->status()];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    private function extractValue($record, $type)
    {
        // dns_get_record returns different keys based on type
        switch ($type) {
            case 'A':
                return $record['ip'] ?? null;
            case 'AAAA':
                return $record['ipv6'] ?? null;
            case 'MX':
                return ($record['pri'] ?? 10) . ' ' . ($record['target'] ?? '');
            case 'CNAME':
                return $record['target'] ?? null;
            case 'NS':
                return $record['target'] ?? null;
            case 'TXT':
                return $record['txt'] ?? null;
            case 'PTR':
                return $record['target'] ?? null;
            case 'SOA':
                return $record['mname'] ?? null;
            default:
                return json_encode($record);
        }
    }
}
