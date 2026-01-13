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
            // Query crt.sh
            $response = Http::timeout(30)->get("https://crt.sh/?q=%25.{$domain}&output=json");

            if ($response->failed()) {
                return back()->with('error', 'Failed to connect to subdomain source.')->withInput();
            }

            $data = $response->json();

            if (!is_array($data)) {
                // Sometimes crt.sh might not return JSON or returns null if no results
                $data = [];
            }

            $subdomains = [];
            foreach ($data as $entry) {
                if (isset($entry['name_value'])) {
                    // entry['name_value'] can contain multiple domains separated by newlines
                    $names = explode("\n", $entry['name_value']);
                    foreach ($names as $name) {
                        $name = trim($name);
                        // Filter out wildcards and the domain itself if you want strictly subdomains,
                        // but usually users want to see everything associated.
                        // Let's keep unique valid subdomains.
                        if ($name && strpos($name, '*') === false) {
                            $subdomains[] = $name;
                        }
                    }
                }
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

            return back()->with('result', [
                'domain' => $domain,
                'subdomains' => $resultsWithIp,
                'count' => count($resultsWithIp)
            ])->withInput();
        } catch (\Exception $e) {
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
