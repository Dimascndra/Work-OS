<?php

namespace App\Http\Controllers;

use App\Support\SecurityToolHelper;
use Illuminate\Http\Request;

class DomainCheckerController extends Controller
{
    public function index()
    {
        return view('pages.domain-checker.index');
    }

    public function check(Request $request)
    {
        $request->validate([
            'domain' => 'required|string',
        ]);

        $domain = SecurityToolHelper::normalizeDomain($request->input('domain'));
        if (!$domain) {
            return back()->withErrors(['domain' => 'Domain tidak valid.'])->withInput();
        }

        // 1. Availability Check (Simple DNS Check)
        // If it has NS or A records, it's definitely registered.
        // If not, it *might* be available (or server configuration error).
        $isRegistered = checkdnsrr($domain, 'NS') || checkdnsrr($domain, 'A');

        // 2. Whois Lookup
        $whoisText = $this->queryWhois($domain);
        $whoisSummary = $this->parseWhois($whoisText);
        $dnsSummary = [
            'ns' => $this->safeDnsRecords($domain, DNS_NS),
            'a' => $this->safeDnsRecords($domain, DNS_A),
            'aaaa' => $this->safeDnsRecords($domain, DNS_AAAA),
            'mx' => $this->safeDnsRecords($domain, DNS_MX),
        ];

        $res = [
            'domain' => $domain,
            'is_registered' => $isRegistered,
            'whois_summary' => $whoisSummary,
            'dns_summary' => $dnsSummary,
            'whois' => $whoisText
        ];

        if ($request->ajax()) {
            $html = view('pages.domain-checker._result', ['res' => $res])->render();
            return response()->json(['success' => true, 'html' => $html]);
        }

        return back()->with('domain_result', $res)->withInput();
    }

    private function queryWhois($domain)
    {
        $server = $this->getWhoisServer($domain);
        if (!$server) return "TLD not supported or unknown whois server.";

        try {
            $fp = @fsockopen($server, 43, $errno, $errstr, 10);
            if (!$fp) return "Could not connect to whois server: $errstr ($errno)";

            $out = $domain . "\r\n";
            fwrite($fp, $out);

            $res = "";
            while (!feof($fp)) {
                $res .= fgets($fp, 128);
            }
            fclose($fp);

            return $res;
        } catch (\Exception $e) {
            return "Whois Lookup Failed: " . $e->getMessage();
        }
    }

    private function getWhoisServer($domain)
    {
        $parts = explode('.', $domain);
        $tld = end($parts);

        $servers = [
            'com' => 'whois.verisign-grs.com',
            'net' => 'whois.verisign-grs.com',
            'org' => 'whois.pir.org',
            'info' => 'whois.afilias.net',
            'io' => 'whois.nic.io',
            'co' => 'whois.nic.co',
            'id' => 'whois.id',
            'dev' => 'whois.nic.google',
            'app' => 'whois.nic.google',
            'biz' => 'whois.biz',
            'us' => 'whois.nic.us',
            'me' => 'whois.nic.me',
            'xyz' => 'whois.nic.xyz',
        ];

        return $servers[$tld] ?? 'whois.iana.org';
    }

    private function parseWhois(string $whois): array
    {
        $fields = [
            'registrar' => '/Registrar:\s*(.+)/i',
            'created' => '/(?:Creation Date|Created On|Created):\s*(.+)/i',
            'updated' => '/(?:Updated Date|Last Updated On|Updated):\s*(.+)/i',
            'expires' => '/(?:Registry Expiry Date|Expiration Date|Expiry Date|Expires On):\s*(.+)/i',
            'status' => '/Domain Status:\s*(.+)/i',
            'name_server' => '/Name Server:\s*(.+)/i',
        ];

        $summary = [];
        foreach ($fields as $key => $pattern) {
            if (preg_match_all($pattern, $whois, $matches)) {
                $values = array_values(array_unique(array_map('trim', $matches[1])));
                $summary[$key] = $key === 'name_server' || $key === 'status' ? $values : ($values[0] ?? null);
            }
        }

        return $summary;
    }

    private function safeDnsRecords(string $domain, int $type): array
    {
        try {
            return dns_get_record($domain, $type) ?: [];
        } catch (\Throwable $e) {
            return [];
        }
    }
}
