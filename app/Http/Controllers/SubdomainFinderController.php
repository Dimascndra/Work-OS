<?php

namespace App\Http\Controllers;

use App\Support\SecurityToolHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SubdomainFinderController extends Controller
{
    public function index()
    {
        return view('pages.subdomain-finder.index');
    }

    public function scan(Request $request)
    {
        $request->validate([
            'url' => 'required',
        ]);

        $domain = SecurityToolHelper::normalizeDomain($request->input('url'));

        if (!$domain) {
            return back()->with('error', 'Domain tidak valid.')->withInput();
        }

        try {
            $subdomains = [];
            $sources = [];
            $errorMsg = null;
            $fetched = false;

            // 1. Try crt.sh
            try {
                $response = Http::timeout(10)->get("https://crt.sh/?q=%25.{$domain}&output=json");
                if ($response->successful()) {
                    $data = $response->json();
                    if (is_array($data)) {
                        foreach ($data as $entry) {
                            if (isset($entry['name_value'])) {
                                $names = explode("\n", $entry['name_value']);
                                foreach ($names as $name) {
                                    $name = trim($name);
                                    if ($name && strpos($name, '*') === false) {
                                        $subdomains[] = $name;
                                        $sources[strtolower(trim($name, '.'))][] = 'crt.sh';
                                    }
                                }
                            }
                        }
                        $fetched = true;
                    }
                }
            } catch (\Exception $e) {
                // crt.sh failed, try fallback
                $errorMsg = "crt.sh failed: " . $e->getMessage();
            }

            // 2. Fallback to HackerTarget if crt.sh failed
            if (!$fetched) {
                try {
                    $response = Http::timeout(10)->get("https://api.hackertarget.com/hostsearch/?q={$domain}");
                    if ($response->successful()) {
                        $lines = explode("\n", $response->body());
                        foreach ($lines as $line) {
                            $parts = explode(',', $line);
                            if (isset($parts[0])) {
                                $name = trim($parts[0]);
                                if ($name && $name !== $domain) { // Basic basic validation
                                    $subdomains[] = $name;
                                    $sources[strtolower(trim($name, '.'))][] = 'HackerTarget';
                                }
                            }
                        }
                        $fetched = true;
                    }
                } catch (\Exception $e2) {
                    $errorMsg .= " | HackerTarget failed: " . $e2->getMessage();
                }
            }

            if (!$fetched && empty($subdomains)) {
                $friendlyError = "Failed to retrieve subdomains from all sources. Service might be busy. Please try again later.";
                if ($request->ajax()) {
                    $html = view('pages.subdomain-finder._result', ['error' => $friendlyError])->render();
                    return response()->json(['success' => false, 'html' => $html]);
                }
                return back()->with('error', $friendlyError)->withInput();
            }

            // Unique and Sort
            $subdomains = array_filter(array_unique(array_map(function ($sub) use ($domain) {
                $sub = strtolower(trim($sub, ". \t\n\r\0\x0B"));
                return str_ends_with($sub, $domain) ? $sub : null;
            }, $subdomains)));
            sort($subdomains);

            // Limit to top 100 to avoid long execution times for huge domains during this demo
            // In production, might want queueing or handling this via AJAX
            $subdomains = array_slice($subdomains, 0, 100);

            $resultsWithIp = [];
            $ipsToQuery = [];

            foreach ($subdomains as $sub) {
                // specific fix for wildcard
                if (strpos($sub, '*') !== false) continue;

                $dns = $this->resolveSubdomain($sub);
                $ip = $dns['ip'];
                $isResolved = $ip !== null;

                $resultsWithIp[] = [
                    'subdomain' => $sub,
                    'ip' => $isResolved ? $ip : null,
                    'aaaa' => $dns['aaaa'],
                    'cname' => $dns['cname'],
                    'sources' => array_values(array_unique($sources[$sub] ?? ['Public records'])),
                    'provider' => 'Unknown',
                    'location' => 'Unknown'
                ];

                if ($isResolved && !in_array($ip, $ipsToQuery)) {
                    $ipsToQuery[] = $ip;
                }
            }

            // Batch query IP-API
            $ipData = [];
            if (count($ipsToQuery) > 0) {
                // Chunk IPs because ip-api batch limit is 100
                $chunks = array_chunk($ipsToQuery, 100);
                foreach ($chunks as $chunk) {
                    try {
                        $apiResponse = Http::post('http://ip-api.com/batch', $chunk);
                        if ($apiResponse->successful()) {
                            foreach ($apiResponse->json() as $info) {
                                if (isset($info['query'])) {
                                    $ipData[$info['query']] = $info;
                                }
                            }
                        }
                    } catch (\Exception $e) {
                        // Silent fail for API, just show IPs
                    }
                }
            }

            // Map data back
            foreach ($resultsWithIp as &$res) {
                if ($res['ip'] && isset($ipData[$res['ip']])) {
                    $info = $ipData[$res['ip']];
                    $res['provider'] = $info['isp'] ?? ($info['org'] ?? 'Unknown');

                    $locParts = [];
                    if (isset($info['city'])) $locParts[] = $info['city'];
                    if (isset($info['country'])) $locParts[] = $info['country'];

                    $res['location'] = implode(', ', $locParts);
                }
            }
            unset($res); // break reference

            if ($request->ajax()) {
                $stats = $this->buildStats($resultsWithIp);
                $html = view('pages.subdomain-finder._result', ['res' => [
                    'domain' => $domain,
                    'subdomains' => $resultsWithIp,
                    'count' => count($resultsWithIp),
                    'resolved_count' => $stats['resolved_count'],
                    'source_count' => $stats['source_count'],
                ]])->render();
                return response()->json(['success' => true, 'html' => $html]);
            }

            $stats = $this->buildStats($resultsWithIp);
            return back()->with('subdomain_result', [
                'domain' => $domain,
                'subdomains' => $resultsWithIp,
                'count' => count($resultsWithIp),
                'resolved_count' => $stats['resolved_count'],
                'source_count' => $stats['source_count'],
            ])->withInput();
        } catch (\Exception $e) {
            if ($request->ajax()) {
                $html = view('pages.subdomain-finder._result', ['error' => "An error occurred: " . $e->getMessage()])->render();
                return response()->json(['success' => false, 'html' => $html]);
            }
            return back()->with('error', "An error occurred: " . $e->getMessage())->withInput();
        }
    }

    private function resolveSubdomain(string $subdomain): array
    {
        $result = ['ip' => null, 'aaaa' => null, 'cname' => null];

        try {
            $a = dns_get_record($subdomain, DNS_A) ?: [];
            $aaaa = dns_get_record($subdomain, DNS_AAAA) ?: [];
            $cname = dns_get_record($subdomain, DNS_CNAME) ?: [];

            $result['ip'] = $a[0]['ip'] ?? null;
            $result['aaaa'] = $aaaa[0]['ipv6'] ?? null;
            $result['cname'] = $cname[0]['target'] ?? null;
        } catch (\Throwable $e) {
            // Leave unresolved values null.
        }

        return $result;
    }

    private function buildStats(array $results): array
    {
        $sources = [];
        foreach ($results as $item) {
            foreach (($item['sources'] ?? []) as $source) {
                $sources[] = $source;
            }
        }

        return [
            'resolved_count' => count(array_filter($results, fn ($item) => !empty($item['ip']) || !empty($item['aaaa']))),
            'source_count' => count(array_unique($sources)),
        ];
    }
}
