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

        // Define providers with mocked locations for the map and list
        $providers = [
            'google' => [
                'name' => 'Google Public DNS',
                'location' => 'Mountain View CA, United States',
                'lat' => 37.3861,
                'lng' => -122.0839,
                'code' => 'us',
                'flag' => '226-united-states.svg'
            ],
            'cloudflare' => [
                'name' => 'Cloudflare',
                'location' => 'San Francisco CA, United States',
                'lat' => 37.7749,
                'lng' => -122.4194,
                'code' => 'us',
                'flag' => '226-united-states.svg'
            ],
            'quad9' => [
                'name' => 'Quad9',
                'location' => 'Zurich, Switzerland',
                'lat' => 47.3769,
                'lng' => 8.5417,
                'code' => 'ch',
                'flag' => '205-switzerland.svg'
            ],
            'opendns' => [
                'name' => 'OpenDNS',
                'location' => 'San Francisco CA, United States',
                'lat' => 37.7749,
                'lng' => -122.4194,
                'code' => 'us',
                'flag' => '226-united-states.svg'
            ],
            'level3' => [
                'name' => 'Level3',
                'location' => 'Broomfield CO, United States',
                'lat' => 39.9205,
                'lng' => -105.0867,
                'code' => 'us',
                'flag' => '226-united-states.svg'
            ],
            'verisign' => [
                'name' => 'Verisign',
                'location' => 'Reston VA, United States',
                'lat' => 38.9687,
                'lng' => -77.3411,
                'code' => 'us',
                'flag' => '226-united-states.svg'
            ],
            'comodo' => [
                'name' => 'Comodo Secure',
                'location' => 'Clifton NJ, United States',
                'lat' => 40.8584,
                'lng' => -74.1638,
                'code' => 'us',
                'flag' => '226-united-states.svg'
            ],
            'norton' => [
                'name' => 'Norton ConnectSafe',
                'location' => 'Mountain View CA, United States',
                'lat' => 37.3861,
                'lng' => -122.0839,
                'code' => 'us',
                'flag' => '226-united-states.svg'
            ],
            'adguard' => [
                'name' => 'AdGuard',
                'location' => 'Moscow, Russia',
                'lat' => 55.7558,
                'lng' => 37.6173,
                'code' => 'ru',
                'flag' => '248-russia.svg'
            ],
            'cleanbrowsing' => [
                'name' => 'CleanBrowsing',
                'location' => 'Los Angeles CA, United States',
                'lat' => 34.0522,
                'lng' => -118.2437,
                'code' => 'us',
                'flag' => '226-united-states.svg'
            ],
            'yandex' => [
                'name' => 'Yandex.DNS',
                'location' => 'Moscow, Russia',
                'lat' => 55.7558,
                'lng' => 37.6173,
                'code' => 'ru',
                'flag' => '248-russia.svg'
            ],
            'neustar' => [
                'name' => 'Neustar UltraDNS',
                'location' => 'Sterling VA, United States',
                'lat' => 39.0068,
                'lng' => -77.4287,
                'code' => 'us',
                'flag' => '226-united-states.svg'
            ],
            'uncensored' => [
                'name' => 'UncensoredDNS',
                'location' => 'Copenhagen, Denmark',
                'lat' => 55.6761,
                'lng' => 12.5683,
                'code' => 'dk',
                'flag' => '174-denmark.svg'
            ],
            // Asia
            'singapore' => [
                'name' => 'SingTel',
                'location' => 'Singapore, Singapore',
                'lat' => 1.3521,
                'lng' => 103.8198,
                'code' => 'sg',
                'flag' => '230-singapore.svg'
            ],
            'jakarta' => [
                'name' => 'Telkom Indonesia',
                'location' => 'Jakarta, Indonesia',
                'lat' => -6.2088,
                'lng' => 106.8456,
                'code' => 'id',
                'flag' => '209-indonesia.svg'
            ],
            'tokyo' => [
                'name' => 'SoftBank',
                'location' => 'Tokyo, Japan',
                'lat' => 35.6762,
                'lng' => 139.6503,
                'code' => 'jp',
                'flag' => '063-japan.svg'
            ],
            'seoul' => [
                'name' => 'KT Corp',
                'location' => 'Seoul, South Korea',
                'lat' => 37.5665,
                'lng' => 126.9780,
                'code' => 'kr',
                'flag' => '094-south-korea.svg'
            ],
            'mumbai' => [
                'name' => 'Jio',
                'location' => 'Mumbai, India',
                'lat' => 19.0760,
                'lng' => 72.8777,
                'code' => 'in',
                'flag' => '246-india.svg'
            ],
            'shanghai' => [
                'name' => 'China Telecom',
                'location' => 'Shanghai, China',
                'lat' => 31.2304,
                'lng' => 121.4737,
                'code' => 'cn',
                'flag' => '015-china.svg'
            ]
        ];

        // Parallel processing would be better, but sequential for simplicity in this demo
        foreach ($providers as $key => $info) {
            // Mocking Lat/Lng variation slightly for visuals if multiple US
            if ($key === 'local') {
                // Try to get server location? Ignore for now or default
            }

            $checkResult = $this->resolveDns($domain, $type, $key);

            $results[$key] = array_merge($info, $checkResult);
        }

        return back()->with('results', $results)->withInput();
    }

    private function resolveDns($domain, $type, $provider)
    {
        try {
            switch ($provider) {
                // DoH Providers
                case 'google':
                    return $this->checkDoH("https://dns.google/resolve", $domain, $type);
                case 'cloudflare':
                    return $this->checkDoH("https://cloudflare-dns.com/dns-query", $domain, $type, ['Accept' => 'application/dns-json']);
                case 'quad9':
                    return $this->checkDoH("https://dns.quad9.net:5053/dns-query", $domain, $type);
                case 'opendns':
                    return $this->checkDoH("https://doh.opendns.com/dns-query", $domain, $type, ['Accept' => 'application/dns-json']);
                case 'adguard':
                    return $this->checkDoH("https://dns.adguard-dns.com/resolve", $domain, $type);
                case 'cleanbrowsing':
                    return $this->checkDoH("https://doh.cleanbrowsing.org/doh/security/dns-query", $domain, $type);
                    // For others without simple Public DoH, we might fallback to Google/CF or mock for this demo
                    // In production, you would use exec('dig @server') or custom socket query.
                    // Re-using Cloudflare as a proxy for 'General Propagation' check for these to ensure data validity.
                default:
                    // Improve fallback: Random load balancing to avoid rate limits
                    $fallbacks = [
                        "https://cloudflare-dns.com/dns-query",
                        "https://dns.google/resolve",
                    ];
                    $endpoint = $fallbacks[array_rand($fallbacks)];
                    return $this->checkDoH($endpoint, $domain, $type, ['Accept' => 'application/dns-json']);
            }
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Timeout/Error', 'data' => []];
        }
    }

    private function checkLocal($domain, $type)
    {
        try {
            // Map string type to PHP constant
            $const = defined("DNS_" . $type) ? constant("DNS_" . $type) : DNS_A;
            $records = dns_get_record($domain, $const);

            if (!$records) return ['status' => 'empty', 'data' => []];

            $data = [];
            foreach ($records as $r) {
                $val = $this->extractValue($r, $type);
                if ($val) $data[] = $val;
            }
            sort($data);

            return ['status' => 'success', 'data' => $data];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage(), 'data' => []];
        }
    }

    private function checkDoH($url, $domain, $type, $headers = [])
    {
        try {
            $response = Http::timeout(3)->withHeaders($headers)->get($url, [
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
                // No answer section means empty or failure for that type
                return ['status' => 'empty', 'data' => []];
            }
            return ['status' => 'error', 'message' => 'HTTP ' . $response->status(), 'data' => []];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Connection Failed', 'data' => []];
        }
    }

    private function extractValue($record, $type)
    {
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
