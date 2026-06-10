<?php

namespace App\Http\Controllers;

use App\Support\SecurityToolHelper;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SslCheckerController extends Controller
{
    public function index()
    {
        return view('pages.ssl-checker.index');
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

        $streamContext = stream_context_create([
            'ssl' => [
                'capture_peer_cert' => true,
                'capture_peer_cert_chain' => true,
                'SNI_enabled' => true,
                'peer_name' => $domain,
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]);

        try {
            // Suppress warnings to handle errors manually (@)
            $client = @stream_socket_client(
                "ssl://{$domain}:443",
                $errno,
                $errstr,
                10, // Timeout in seconds
                STREAM_CLIENT_CONNECT,
                $streamContext
            );

            if (!$client) {
                $friendlyError = "Tidak dapat terhubung ke {$domain}.";

                // Map common errors to friendly messages
                if (strpos($errstr, 'getaddrinfo') !== false || strpos($errstr, 'No such host') !== false) {
                    $friendlyError = "Domain '{$domain}' tidak ditemukan. Silakan periksa kembali ejaannya.";
                } elseif (strpos($errstr, 'timed out') !== false) {
                    $friendlyError = "Koneksi ke '{$domain}' terputus (timed out). Server mungkin sedang tidak aktif.";
                } elseif (strpos($errstr, 'ssl') !== false) {
                    $friendlyError = "Handshake SSL/TLS gagal untuk '{$domain}'. Situs tersebut mungkin tidak memiliki SSL.";
                } elseif ($errno == 0 && empty($errstr)) {
                    $friendlyError = "Koneksi gagal. Silakan periksa koneksi internet Anda atau nama domain.";
                }

                if ($request->ajax()) {
                    $html = view('pages.ssl-checker._result', ['error' => $friendlyError])->render();
                    return response()->json(['success' => false, 'html' => $html]);
                }

                return back()->with('error', $friendlyError)->withInput();
            }

            $context = stream_context_get_params($client);
            $cert = openssl_x509_parse($context['options']['ssl']['peer_certificate']);
            $chain = $context['options']['ssl']['peer_certificate_chain'] ?? [];
            $fingerprint = function_exists('openssl_x509_fingerprint')
                ? openssl_x509_fingerprint($context['options']['ssl']['peer_certificate'], 'sha256')
                : null;
            $meta = stream_get_meta_data($client);

            if (!$cert) {
                if ($request->ajax()) {
                    $html = view('pages.ssl-checker._result', ['error' => "Tidak dapat mengurai sertifikat untuk {$domain}."])->render();
                    return response()->json(['success' => false, 'html' => $html]);
                }
                return back()->with('error', "Tidak dapat mengurai sertifikat untuk {$domain}.")
                    ->withInput();
            }

            $validFrom = Carbon::createFromTimestamp($cert['validFrom_time_t']);
            $validTo = Carbon::createFromTimestamp($cert['validTo_time_t']);
            $currentData = Carbon::now();
            $daysRemaining = $currentData->diffInDays($validTo, false);

            $status = 'valid';
            if ($daysRemaining < 0) {
                $status = 'expired';
            } elseif ($daysRemaining < 30) {
                $status = 'warning';
            }

            $certificateData = [
                'domain' => $domain,
                'issuer' => $cert['issuer']['CN'] ?? $cert['issuer']['O'] ?? 'Unknown',
                'subject' => $cert['subject']['CN'] ?? $domain,
                'serial_number' => $cert['serialNumberHex'] ?? $cert['serialNumber'] ?? 'Unknown',
                'signature_type' => $cert['signatureTypeLN'] ?? 'Unknown',
                'fingerprint_sha256' => strtoupper($fingerprint ?: 'Unknown'),
                'san' => $this->extractSubjectAltNames($cert),
                'chain_count' => count($chain),
                'protocol' => $meta['crypto']['protocol'] ?? 'Unknown',
                'cipher' => $meta['crypto']['cipher_name'] ?? 'Unknown',
                'valid_from' => $validFrom->format('d M Y H:i:s'),
                'valid_to' => $validTo->format('d M Y H:i:s'),
                'days_remaining' => (int) $daysRemaining,
                'status' => $status,
                'details' => $cert
            ];

            if ($request->ajax()) {
                $html = view('pages.ssl-checker._result', ['res' => $certificateData])->render();
                return response()->json(['success' => true, 'html' => $html]);
            }

            return back()->with('ssl_result', $certificateData)->withInput();
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            if (strpos($msg, 'getaddrinfo') !== false) {
                $msg = "Domain tidak ditemukan.";
            }

            if ($request->ajax()) {
                $html = view('pages.ssl-checker._result', ['error' => "Gagal memeriksa {$domain}: " . $msg])->render();
                return response()->json(['success' => false, 'html' => $html]);
            }

            return back()->with('error', "Gagal memeriksa {$domain}: " . $msg)->withInput();
        }
    }

    private function extractSubjectAltNames(array $cert): array
    {
        $raw = $cert['extensions']['subjectAltName'] ?? '';
        if ($raw === '') {
            return [];
        }

        $names = [];
        foreach (explode(',', $raw) as $part) {
            $part = trim($part);
            if (stripos($part, 'DNS:') === 0) {
                $names[] = substr($part, 4);
            }
        }

        return array_values(array_unique($names));
    }
}
