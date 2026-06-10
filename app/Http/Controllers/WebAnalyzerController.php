<?php

namespace App\Http\Controllers;

use App\Support\SecurityToolHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DOMDocument;

class WebAnalyzerController extends Controller
{
    public function index()
    {
        return view('pages.web-analyzer.index');
    }

    public function analyze(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        $url = SecurityToolHelper::normalizeUrl($request->input('url'));
        if (!$url) {
            return back()->withErrors(['url' => 'URL tidak valid.'])->withInput();
        }
        $result = [];

        try {
            // 1. Performance Check
            $startTime = microtime(true);
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
            ])->timeout(10)->get($url);
            $endTime = microtime(true);

            $loadTime = round(($endTime - $startTime) * 1000, 2); // in ms
            $size = strlen($response->body());

            // Health Score Calculation Base
            $score = 100;
            $passedChecks = 0;
            $totalChecks = 0;

            // Performance Grading
            if ($loadTime < 500) {
                $perfGrade = 'A';
            } elseif ($loadTime < 1000) {
                $perfGrade = 'B';
                $score -= 5;
            } elseif ($loadTime < 2000) {
                $perfGrade = 'C';
                $score -= 10;
            } else {
                $perfGrade = 'D';
                $score -= 20;
            }

            $result['performance'] = [
                'load_time' => $loadTime . ' ms',
                'size' => round($size / 1024, 2) . ' KB',
                'status_code' => $response->status(),
                'grade' => $perfGrade
            ];

            // 2. Security Headers Check
            $headers = $response->headers();
            $headerMap = [];
            foreach ($headers as $key => $value) {
                $headerMap[strtolower($key)] = is_array($value) ? implode(', ', $value) : $value;
            }
            $securityChecks = [
                'X-Frame-Options' => ['desc' => 'Melindungi dari serangan Clickjacking', 'passed' => false],
                'X-XSS-Protection' => ['desc' => 'Mengaktifkan filter XSS pada browser', 'passed' => false],
                'X-Content-Type-Options' => ['desc' => 'Mencegah MIME-sniffing', 'passed' => false],
                'Strict-Transport-Security' => ['desc' => 'Memaksakan penggunaan HTTPS (HSTS)', 'passed' => false],
                'Content-Security-Policy' => ['desc' => 'Memitigasi XSS dan injeksi data', 'passed' => false],
                'Referrer-Policy' => ['desc' => 'Mengontrol informasi pengirim (referrer)', 'passed' => false],
            ];

            foreach ($securityChecks as $header => &$info) {
                // Http Client headers are usually array or line
                // Laravel Http client returns lower-case keys sometimes depending on adapter?
                // Let's check case-insensitive
                $found = false;
                foreach ($headers as $key => $value) {
                    if (strtolower($key) === strtolower($header)) {
                        $found = true;
                        break;
                    }
                }

                if ($found) {
                    $info['passed'] = true;
                    $passedChecks++;
                } else {
                    $score -= 5; // Deduct for missing security headers
                }
                $totalChecks++;
            }
            $result['security'] = $securityChecks;

            // 3. SEO & Tech Stack (Parsing HTML)
            $html = $response->body();

            // Suppress DOM warnings
            libxml_use_internal_errors(true);
            $dom = new DOMDocument();
            $dom->loadHTML($html);
            libxml_clear_errors();

            // SEO Tags
            $title = $dom->getElementsByTagName('title')->item(0)?->textContent;

            $metas = $dom->getElementsByTagName('meta');
            $description = null;
            $generator = null;
            $viewport = null;
            $openGraph = 0;

            foreach ($metas as $meta) {
                if (strtolower($meta->getAttribute('name')) == 'description') {
                    $description = $meta->getAttribute('content');
                }
                if (strtolower($meta->getAttribute('name')) == 'generator') {
                    $generator = $meta->getAttribute('content');
                }
                if (strtolower($meta->getAttribute('name')) == 'viewport') {
                    $viewport = $meta->getAttribute('content');
                }
                if (stripos($meta->getAttribute('property'), 'og:') === 0) {
                    $openGraph++;
                }
            }

            $canonical = null;
            foreach ($dom->getElementsByTagName('link') as $link) {
                if (strtolower($link->getAttribute('rel')) === 'canonical') {
                    $canonical = $link->getAttribute('href');
                    break;
                }
            }

            // Headings
            $h1Count = $dom->getElementsByTagName('h1')->length;
            $h2Count = $dom->getElementsByTagName('h2')->length;
            $lang = $dom->getElementsByTagName('html')->item(0)?->getAttribute('lang');

            // Images Alt
            $images = $dom->getElementsByTagName('img');
            $imagesWithoutAlt = 0;
            $totalImages = $images->length;
            foreach ($images as $img) {
                if (!$img->getAttribute('alt')) {
                    $imagesWithoutAlt++;
                }
            }

            // SEO Checks
            $seoChecks = [
                'Tag Title' => ['passed' => !empty($title), 'val' => $title ?? 'Tidak Ada'],
                'Meta Deskripsi' => ['passed' => !empty($description), 'val' => $description ? substr($description, 0, 50) . '...' : 'Tidak Ada'],
                'Heading H1' => ['passed' => $h1Count > 0, 'val' => $h1Count . ' ditemukan'],
                'Atribut Alt Gambar' => ['passed' => $imagesWithoutAlt === 0, 'val' => $imagesWithoutAlt . ' gambar tanpa alt dari total ' . $totalImages],
                'URL Kanonikal' => ['passed' => !empty($canonical), 'val' => $canonical ? substr($canonical, 0, 60) : 'Tidak Ada'],
                'Meta Viewport' => ['passed' => !empty($viewport), 'val' => $viewport ? 'Ditemukan' : 'Tidak Ada'],
            ];

            foreach ($seoChecks as $check) {
                if ($check['passed']) $passedChecks++;
                else $score -= 5;
                $totalChecks++;
            }

            $result['seo'] = $seoChecks;
            $result['seo_data'] = [
                'title' => $title,
                'description' => $description,
                'h1_count' => $h1Count,
                'h2_count' => $h2Count,
                'viewport' => $viewport,
                'canonical' => $canonical,
                'open_graph_count' => $openGraph,
                'lang' => $lang ?: 'Tidak disetel',
            ];

            // 4. Tech Stack (Simple Detection)
            $server = $response->header('Server') ?? 'Disembunyikan';
            $poweredBy = $response->header('X-Powered-By') ?? 'Disembunyikan';

            $result['tech'] = [
                'Server' => $server,
                'X-Powered-By' => $poweredBy,
                'Generator' => $generator ?? 'Tidak Terdeteksi',
            ];

            $robotsUrl = rtrim(parse_url($url, PHP_URL_SCHEME) . '://' . parse_url($url, PHP_URL_HOST), '/') . '/robots.txt';
            $robotsStatus = null;
            try {
                $robotsStatus = Http::timeout(5)->get($robotsUrl)->status();
            } catch (\Exception $e) {
                $robotsStatus = 'tidak dapat dijangkau';
            }

            $result['advanced'] = [
                'compression' => $headerMap['content-encoding'] ?? 'Tidak terdeteksi',
                'cache_control' => $headerMap['cache-control'] ?? 'Tidak disetel',
                'robots_txt' => $robotsStatus,
                'canonical' => $canonical ?: 'Tidak disetel',
                'open_graph_tags' => $openGraph,
                'language' => $lang ?: 'Tidak disetel',
            ];

            // 5. Recommendations
            $recommendations = [];

            // Performance Recs
            if ($loadTime > 500) {
                $recommendations[] = 'Optimalkan gambar dan skrip untuk mengurangi Waktu Pemuatan (saat ini ' . $loadTime . 'ms). Target: < 500ms.';
            }
            if ($size > 2048 * 1024) { // 2MB
                $recommendations[] = 'Ukuran halaman sangat besar (' . round($size / 1024, 2) . 'KB). Aktifkan kompresi (Gzip/Brotli) atau perkecil aset.';
            }

            // SEO Recs
            if (empty($title)) $recommendations[] = 'Tambahkan tag <title> untuk menentukan judul halaman bagi mesin pencari.';
            if (empty($description)) $recommendations[] = 'Tambahkan tag <meta name="description"> untuk meningkatkan rasio klik dari hasil pencarian.';
            if ($h1Count === 0) $recommendations[] = 'Tambahkan heading utama <h1> untuk menyusun hierarki konten Anda.';
            if ($imagesWithoutAlt > 0) $recommendations[] = 'Tambahkan atribut "alt" pada ' . $imagesWithoutAlt . ' gambar untuk meningkatkan aksesibilitas dan SEO.';
            if (empty($canonical)) $recommendations[] = 'Tambahkan tautan kanonikal untuk mengurangi ambiguitas konten duplikat.';
            if (empty($viewport)) $recommendations[] = 'Tambahkan tag meta viewport untuk tampilan mobile yang lebih baik.';
            if ($openGraph === 0) $recommendations[] = 'Tambahkan tag meta Open Graph agar tautan yang dibagikan memiliki pratinjau yang lebih baik.';

            // Security Recs
            if (!$securityChecks['Strict-Transport-Security']['passed']) $recommendations[] = 'Aktifkan "Strict-Transport-Security" (HSTS) untuk memaksakan koneksi HTTPS.';
            if (!$securityChecks['X-Frame-Options']['passed']) $recommendations[] = 'Tambahkan header "X-Frame-Options" (DENY atau SAMEORIGIN) untuk mencegah Clickjacking.';
            if (!$securityChecks['Content-Security-Policy']['passed']) $recommendations[] = 'Terapkan "Content-Security-Policy" (CSP) untuk mencegah XSS dan injeksi data.';
            if (!$securityChecks['X-Content-Type-Options']['passed']) $recommendations[] = 'Tambahkan "X-Content-Type-Options: nosniff" untuk mencegah MIME-type sniffing.';

            $result['recommendations'] = $recommendations;

            // Final Score Cap
            $score = max(0, $score);
            $result['overall_score'] = $score;
            $result['url'] = $url;
            $result['timestamp'] = date('Y-m-d H:i:s');

            if ($request->ajax()) {
                $html = view('pages.web-analyzer._result', ['res' => $result])->render();
                return response()->json(['success' => true, 'html' => $html]);
            }

            return back()->with('web_analyzer_result', $result)->withInput();
        } catch (\Exception $e) {
            if ($request->ajax()) {
                $html = view('pages.web-analyzer._result', ['error' => 'Could not analyze URL. ' . $e->getMessage()])->render();
                return response()->json(['success' => false, 'html' => $html]);
            }
            return back()->with('error', 'Could not analyze URL. ' . $e->getMessage())->withInput();
        }
    }
}
