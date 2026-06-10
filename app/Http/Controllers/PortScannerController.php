<?php

namespace App\Http\Controllers;

use App\Support\SecurityToolHelper;
use Illuminate\Http\Request;

class PortScannerController extends Controller
{
    public function index()
    {
        return view('pages.port-scanner.index');
    }

    public function scan(Request $request)
    {
        $request->validate([
            'target' => 'required|string',
        ]);

        $input = trim($request->input('target'));
        // Clean URL to Domain/IP if input is copy-pasted as URL
        if (preg_match('#^https?://#', $input)) {
            $parsed = parse_url($input);
            $target = $parsed['host'] ?? $input;
        } else {
            $target = $input;
        }

        // Validate IP or Domain Name
        if (!filter_var($target, FILTER_VALIDATE_IP) && !preg_match('/^([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,}$/i', $target)) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Target IP atau Domain tidak valid.']);
            }
            return back()->withErrors(['target' => 'Target IP atau Domain tidak valid.'])->withInput();
        }

        // Define standard ports to check
        $ports = [
            21   => ['name' => 'FTP', 'desc' => 'File Transfer Protocol - Transfer berkas antar host.'],
            22   => ['name' => 'SSH', 'desc' => 'Secure Shell - Remote login aman ke terminal server.'],
            23   => ['name' => 'Telnet', 'desc' => 'Terminal Network - Remote login tidak terenkripsi (tidak aman).'],
            25   => ['name' => 'SMTP', 'desc' => 'Simple Mail Transfer Protocol - Pengiriman email.'],
            53   => ['name' => 'DNS', 'desc' => 'Domain Name System - Resolusi nama domain ke alamat IP.'],
            80   => ['name' => 'HTTP', 'desc' => 'Hypertext Transfer Protocol - Server web standar (tidak aman).'],
            110  => ['name' => 'POP3', 'desc' => 'Post Office Protocol v3 - Pengambilan email.'],
            143  => ['name' => 'IMAP', 'desc' => 'Internet Message Access Protocol - Sinkronisasi direktori email.'],
            443  => ['name' => 'HTTPS', 'desc' => 'Hypertext Transfer Protocol Secure - Server web terenkripsi SSL/TLS.'],
            3306 => ['name' => 'MySQL', 'desc' => 'MySQL Database Service - Koneksi ke database MySQL.'],
            3389 => ['name' => 'RDP', 'desc' => 'Remote Desktop Protocol - Antarmuka grafis remote Windows.'],
            8080 => ['name' => 'HTTP Alt', 'desc' => 'HTTP Alternative - Sering digunakan untuk proxy atau aplikasi web sekunder.'],
        ];

        $results = [];
        $openCount = 0;

        foreach ($ports as $port => $info) {
            // Check port connection with short timeout (0.35s)
            $connection = @fsockopen($target, $port, $errno, $errstr, 0.35);

            if (is_resource($connection)) {
                $status = 'open';
                $openCount++;
                fclose($connection);
            } else {
                $status = 'closed';
            }

            $results[] = [
                'port'   => $port,
                'name'   => $info['name'],
                'desc'   => $info['desc'],
                'status' => $status
            ];
        }

        $res = [
            'target'     => $target,
            'open_count' => $openCount,
            'ports'      => $results,
            'total_checked' => count($ports)
        ];

        if ($request->ajax()) {
            $html = view('pages.port-scanner._result', ['res' => $res])->render();
            return response()->json(['success' => true, 'html' => $html]);
        }

        return back()->with('port_result', $res)->withInput();
    }
}
