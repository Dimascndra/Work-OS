<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $urls = ShortUrl::latest()->paginate(10);
        return view('pages.short-urls.index', compact('urls'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
            'title' => 'nullable|string|max:255',
            'custom_code' => 'nullable|string|unique:short_urls,short_code|max:20',
        ]);

        $code = $request->custom_code;

        if (!$code) {
            $code = $this->generateUniqueCode();
        }

        ShortUrl::create([
            'title' => $request->title,
            'original_url' => $request->original_url,
            'short_code' => $code,
        ]);

        return redirect()->route('short-urls.index')->with('success', 'Short URL created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShortUrl $shortUrl)
    {
        $shortUrl->delete();
        return redirect()->route('short-urls.index')->with('success', 'Short URL deleted successfully!');
    }

    /**
     * Redirect to the original URL.
     */
    public function redirect($code)
    {
        $shortUrl = ShortUrl::where('short_code', $code)->firstOrFail();
        $shortUrl->increment('clicks');
        return redirect($shortUrl->original_url);
    }

    /**
     * Generate a unique short code.
     */
    private function generateUniqueCode()
    {
        do {
            $code = Str::random(6);
        } while (ShortUrl::where('short_code', $code)->exists());
        return $code;
    }
}
