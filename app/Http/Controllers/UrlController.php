<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LongUrlRequest;
use App\Http\Requests\ShortUrlRequest;
use App\Url;
use Illuminate\Support\Facades\Auth;


class UrlController extends Controller
{
    /**
     * Generating short URL
     * @param LongUrlRequest $request (have long url for generating short url)
     * @return \Illuminate\Http\RedirectResponse (redirect on main page of site with generated short url)
     */
    public function postUrlGenerate(LongUrlRequest $request)
    {
        $input = $request->all();

        if(isset($input['short_url'])) {
            $shortUrl = $input['short_url'];
        } else {
            //generating short url
            $urls = Url::get();
            $shortUrl = $this->generateShortUrl();
            $countUrls = $urls->where('short_url',$shortUrl)->count();
            while ($countUrls > 0 ) {
                $shortUrl = $this->generateShortUrl();
                $countUrls = $urls->where('short_url',$shortUrl)->count();
            }
        }

        //verifying authorization
        $userId = Auth::check() ? Auth::user()->id : null;

        //inserting info in DB
        Url::create([
            'long_url' => $input['long_url'],
            'short_url' => $shortUrl,
            'user_id' => $userId
        ]);

        $shortUrlLink = url('/') . '/' . $shortUrl;

        return redirect()->back()->with('shortUrlLink',$shortUrlLink);
    }

    /**
     * redirecting on long url
     * @param $url - short url
     * @return $this|\Illuminate\Http\RedirectResponse - redirect to long url
     */
    public function getUrlRedirect($url)
    {
        $urlObj = Url::where('short_url',$url)->first();

        if ($urlObj) {
            Url::where('short_url',$url)->update([
                'count_clicks' => $urlObj->count_clicks + 1,
            ]);

            return redirect()->intended($urlObj->long_url, 301);
        } else {
            return redirect('/')->withErrors(array('unknown_url' => 'Unknown url'));
        }
    }

    /**
     * random generating string
     * @return string
     */
    public function generateShortUrl()
    {
        $length = 6;
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

    /**
     * editing short url by user
     * @param ShortUrlRequest $request - remaded short url
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector - redirect on main page of site
     */
    public function postUrlEdit(ShortUrlRequest $request)
    {
        $input = $request->all();
        Url::where('id', $input['id'])->update([
            'short_url' =>$input['short_url']
        ]);
        $urls = \Auth::user()->urls()->paginate(5);
        return view('pages.index.table', compact('urls'));
    }

    public function getUrlErrorMessage()
    {
        return view('pages.messages.error');
    }
}
