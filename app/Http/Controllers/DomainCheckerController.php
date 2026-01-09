<?php

namespace App\Http\Controllers;

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

        $domain = $request->input('domain');
        // Cleanup
        $domain = preg_replace('#^https?://#', '', $domain);
        $domain = rtrim($domain, '/');
        $domain = strtolower($domain);

        // 1. Availability Check (Simple DNS Check)
        // If it has NS or A records, it's definitely registered.
        // If not, it *might* be available (or server configuration error).
        $isRegistered = checkdnsrr($domain, 'NS') || checkdnsrr($domain, 'A');

        // 2. Whois Lookup
        $whoisText = $this->queryWhois($domain);

        return back()->with('result', [
            'domain' => $domain,
            'is_registered' => $isRegistered,
            'whois' => $whoisText
        ])->withInput();
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
}
