<?php

namespace App\Http\Controllers;

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

        $input = $request->input('url');

        // Extract domain from URL or use input as is if it looks like a domain
        $domain = $this->extractDomain($input);

        if (!$domain) {
            return back()->with('error', 'Invalid domain provided.')->withInput();
        }

        try {
            $subdomains = [];
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
            $subdomains = array_unique($subdomains);
            sort($subdomains);

            // Limit to top 100 to avoid long execution times for huge domains during this demo
            // In production, might want queueing or handling this via AJAX
            $subdomains = array_slice($subdomains, 0, 100);

            $resultsWithIp = [];
            $ipsToQuery = [];

            foreach ($subdomains as $sub) {
                // specific fix for wildcard
                if (strpos($sub, '*') !== false) continue;

                $ip = gethostbyname($sub);
                $isResolved = $ip !== $sub; // gethostbyname returns domain on failure

                $resultsWithIp[] = [
                    'subdomain' => $sub,
                    'ip' => $isResolved ? $ip : null,
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
                $html = view('pages.subdomain-finder._result', ['res' => [
                    'domain' => $domain,
                    'subdomains' => $resultsWithIp,
                    'count' => count($resultsWithIp)
                ]])->render();
                return response()->json(['success' => true, 'html' => $html]);
            }

            return back()->with('subdomain_result', [
                'domain' => $domain,
                'subdomains' => $resultsWithIp,
                'count' => count($resultsWithIp)
            ])->withInput();
        } catch (\Exception $e) {
            if ($request->ajax()) {
                $html = view('pages.subdomain-finder._result', ['error' => "An error occurred: " . $e->getMessage()])->render();
                return response()->json(['success' => false, 'html' => $html]);
            }
            return back()->with('error', "An error occurred: " . $e->getMessage())->withInput();
        }
    }

    private function extractDomain($url)
    {
        // Add scheme if missing to help parse_url
        if (strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
            $url = 'http://' . $url;
        }

        $parsed = parse_url($url);

        if (isset($parsed['host'])) {
            return $parsed['host'];
        }

        return null;
    }
}
