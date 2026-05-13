<?php

namespace App\Services;

use App\Models\DomainMonitor;
use Illuminate\Database\Eloquent\Collection;

class DomainMonitorService
{
    public function getAll(): Collection
    {
        return DomainMonitor::latest()->get();
    }

    public function create(array $data): DomainMonitor
    {
        return DomainMonitor::create($data);
    }

    public function update(DomainMonitor $domainMonitor, array $data): DomainMonitor
    {
        $domainMonitor->update($data);
        return $domainMonitor->refresh();
    }

    public function delete(DomainMonitor $domainMonitor): bool
    {
        return $domainMonitor->delete();
    }

    public function checkDomain(DomainMonitor $domainMonitor): DomainMonitor
    {
        $url    = $domainMonitor->domain_url;
        $host   = parse_url($url, PHP_URL_HOST) ?: $url;
        $status = 'down';

        // ── 1. HTTP Status Check ───────────────────────────────────────────────
        try {
            $context = stream_context_create([
                'http' => ['timeout' => 10, 'follow_location' => true, 'method' => 'HEAD'],
                'ssl'  => ['verify_peer' => false, 'verify_peer_name' => false],
            ]);
            $headers = @get_headers($url, true, $context);

            if ($headers && isset($headers[0])) {
                $code = (int) substr($headers[0], 9, 3);
                if ($code >= 200 && $code < 400)      $status = 'healthy';
                elseif ($code >= 400 && $code < 500)  $status = 'warning';
                else                                   $status = 'down';
            }
        } catch (\Exception) {
            $status = 'down';
        }

        // ── 2. SSL Certificate Expiry ──────────────────────────────────────────
        $sslExpiresAt = $this->checkSslExpiry($host);

        // ── 3. Domain Expiry via WHOIS ─────────────────────────────────────────
        $domainExpiresAt = $this->checkDomainExpiry($host);

        $domainMonitor->update([
            'status'            => $status,
            'ssl_expires_at'    => $sslExpiresAt,
            'domain_expires_at' => $domainExpiresAt,
            'last_checked_at'   => now(),
        ]);

        return $domainMonitor->refresh();
    }

    // ── SSL Expiry via OpenSSL Stream ──────────────────────────────────────────
    private function checkSslExpiry(string $host): ?\Carbon\Carbon
    {
        try {
            $context = stream_context_create([
                'ssl' => [
                    'capture_peer_cert' => true,
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                ],
            ]);

            $socket = @stream_socket_client(
                "ssl://{$host}:443",
                $errno,
                $errstr,
                10,
                STREAM_CLIENT_CONNECT,
                $context
            );

            if (!$socket) return null;

            $params = stream_context_get_params($socket);
            fclose($socket);

            $cert = openssl_x509_parse($params['options']['ssl']['peer_certificate']);
            if (!$cert || empty($cert['validTo_time_t'])) return null;

            return \Carbon\Carbon::createFromTimestamp($cert['validTo_time_t']);
        } catch (\Exception) {
            return null;
        }
    }

    // ── Domain Expiry via WHOIS ────────────────────────────────────────────────
    private function checkDomainExpiry(string $host): ?\Carbon\Carbon
    {
        try {
            // Strip subdomains — only use registrable domain (e.g. google.com from www.google.com)
            $parts = explode('.', $host);
            $domain = implode('.', array_slice($parts, -2));

            $tld    = end($parts);
            $server = $this->getWhoisServer($tld);

            $fp = @fsockopen($server, 43, $errno, $errstr, 10);
            if (!$fp) return null;

            fwrite($fp, $domain . "\r\n");

            $raw = '';
            while (!feof($fp)) {
                $raw .= fgets($fp, 128);
            }
            fclose($fp);

            return $this->parseExpiryFromWhois($raw);
        } catch (\Exception) {
            return null;
        }
    }

    private function parseExpiryFromWhois(string $raw): ?\Carbon\Carbon
    {
        // Common WHOIS expiry field patterns
        $patterns = [
            '/Registry Expiry Date:\s*(.+)/i',
            '/Expiration Date:\s*(.+)/i',
            '/Expiry Date:\s*(.+)/i',
            '/expires:\s*(.+)/i',
            '/paid-till:\s*(.+)/i',
            '/Expiration Time:\s*(.+)/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $raw, $matches)) {
                $date = trim($matches[1]);
                try {
                    return \Carbon\Carbon::parse($date);
                } catch (\Exception) {
                    continue;
                }
            }
        }

        return null;
    }

    private function getWhoisServer(string $tld): string
    {
        $servers = [
            'com'  => 'whois.verisign-grs.com',
            'net'  => 'whois.verisign-grs.com',
            'org'  => 'whois.pir.org',
            'info' => 'whois.afilias.net',
            'io'   => 'whois.nic.io',
            'co'   => 'whois.nic.co',
            'id'   => 'whois.id',
            'dev'  => 'whois.nic.google',
            'app'  => 'whois.nic.google',
            'biz'  => 'whois.biz',
            'us'   => 'whois.nic.us',
            'me'   => 'whois.nic.me',
            'xyz'  => 'whois.nic.xyz',
            'my'   => 'whois.mynic.my',
            'sg'   => 'whois.sgnic.sg',
            'uk'   => 'whois.nic.uk',
            'au'   => 'whois.auda.org.au',
        ];

        return $servers[$tld] ?? 'whois.iana.org';
    }
}
