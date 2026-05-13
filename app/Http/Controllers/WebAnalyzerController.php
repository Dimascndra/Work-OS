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
                'X-Frame-Options' => ['desc' => 'Protects against Clickjacking', 'passed' => false],
                'X-XSS-Protection' => ['desc' => 'Enables browser XSS filtering', 'passed' => false],
                'X-Content-Type-Options' => ['desc' => 'Prevents MIME-sniffing', 'passed' => false],
                'Strict-Transport-Security' => ['desc' => 'Enforces HTTPS (HSTS)', 'passed' => false],
                'Content-Security-Policy' => ['desc' => 'Mitigates XSS and data injection', 'passed' => false],
                'Referrer-Policy' => ['desc' => 'Controls referrer information', 'passed' => false],
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
                'Title Tag' => ['passed' => !empty($title), 'val' => $title ?? 'Missing'],
                'Meta Description' => ['passed' => !empty($description), 'val' => $description ? substr($description, 0, 50) . '...' : 'Missing'],
                'H1 Heading' => ['passed' => $h1Count > 0, 'val' => $h1Count . ' found'],
                'Image Alt text' => ['passed' => $imagesWithoutAlt === 0, 'val' => $imagesWithoutAlt . ' missing alt out of ' . $totalImages],
                'Canonical URL' => ['passed' => !empty($canonical), 'val' => $canonical ? substr($canonical, 0, 60) : 'Missing'],
                'Viewport Meta' => ['passed' => !empty($viewport), 'val' => $viewport ? 'Found' : 'Missing'],
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
                'lang' => $lang ?: 'Not set',
            ];

            // 4. Tech Stack (Simple Detection)
            $server = $response->header('Server') ?? 'Hidden';
            $poweredBy = $response->header('X-Powered-By') ?? 'Hidden';

            $result['tech'] = [
                'Server' => $server,
                'X-Powered-By' => $poweredBy,
                'Generator' => $generator ?? 'Not Detected',
            ];

            $robotsUrl = rtrim(parse_url($url, PHP_URL_SCHEME) . '://' . parse_url($url, PHP_URL_HOST), '/') . '/robots.txt';
            $robotsStatus = null;
            try {
                $robotsStatus = Http::timeout(5)->get($robotsUrl)->status();
            } catch (\Exception $e) {
                $robotsStatus = 'unreachable';
            }

            $result['advanced'] = [
                'compression' => $headerMap['content-encoding'] ?? 'Not detected',
                'cache_control' => $headerMap['cache-control'] ?? 'Not set',
                'robots_txt' => $robotsStatus,
                'canonical' => $canonical ?: 'Not set',
                'open_graph_tags' => $openGraph,
                'language' => $lang ?: 'Not set',
            ];

            // 5. Recommendations
            $recommendations = [];

            // Performance Recs
            if ($loadTime > 500) {
                $recommendations[] = 'Optimize images and scripts to reduce Load Time (currently ' . $loadTime . 'ms). Goal: < 500ms.';
            }
            if ($size > 2048 * 1024) { // 2MB
                $recommendations[] = 'Page size is large (' . round($size / 1024, 2) . 'KB). Enable compression (Gzip/Brotli) or minify assets.';
            }

            // SEO Recs
            if (empty($title)) $recommendations[] = 'Add a <title> tag to specificy the page title for search engines.';
            if (empty($description)) $recommendations[] = 'Add a <meta name="description"> tag to improve click-through rates from search results.';
            if ($h1Count === 0) $recommendations[] = 'Add a main <h1> heading to structure your content hierarchy.';
            if ($imagesWithoutAlt > 0) $recommendations[] = 'Add "alt" attributes to ' . $imagesWithoutAlt . ' images to improve accessibility and SEO.';
            if (empty($canonical)) $recommendations[] = 'Add a canonical link to reduce duplicate-content ambiguity.';
            if (empty($viewport)) $recommendations[] = 'Add a viewport meta tag for better mobile rendering.';
            if ($openGraph === 0) $recommendations[] = 'Add Open Graph meta tags so shared links have better previews.';

            // Security Recs
            if (!$securityChecks['Strict-Transport-Security']['passed']) $recommendations[] = 'Enable "Strict-Transport-Security" (HSTS) to enforce HTTPS connections.';
            if (!$securityChecks['X-Frame-Options']['passed']) $recommendations[] = 'Add "X-Frame-Options" header (DENY or SAMEORIGIN) to prevent Clickjacking.';
            if (!$securityChecks['Content-Security-Policy']['passed']) $recommendations[] = 'Implement a "Content-Security-Policy" (CSP) to prevent XSS and data injection.';
            if (!$securityChecks['X-Content-Type-Options']['passed']) $recommendations[] = 'Add "X-Content-Type-Options: nosniff" to prevent MIME-type sniffing.';

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
