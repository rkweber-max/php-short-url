<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;

class UrlManager extends Controller
{
    function createShortUrl(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url'
        ]);

        $url = Url::where('original_url', $request->original_url)->first();

        if (!$url) {
            $shortCode = Url::generateShortCode();

            $url = new Url();
            $url->original_url = $request->original_url;
            $url->short_code = $shortCode;
            $url->save();
        }

        return response()->json([
            'short_url' => url('/') . '/' . $url->short_code
        ]);
    }

    function redirectToOriginalUrl($code)
    {
        $url = Url::where('short_code', $code)->first();

        if (!$url)
            abort(404);

        $url->increment('visits');

        return redirect($url->original_url);
    }

    function stats($code)
    {
        $url = Url::where('short_code', $code)->first();

        if (!$url)
            abort(404);

        return response()->json([
            'original_url' => $url->original_url,
            'short_url' => url('/') . '/' . $url->short_code,
            'visits' => $url->visits,
        ]);
    }
}
