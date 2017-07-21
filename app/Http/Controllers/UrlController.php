<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LongUrlRequest;
use App\Http\Requests\ShortUrlRequest;
use App\Models\Url;
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
        //if user send short url
        if(isset($input['short_url'])&& (!(empty($input['short_url'])))) {
            $shortUrl = $input['short_url'];
        } else {
            //generating short url
            $urls = Url::get();
            $shortUrl = $this->generateShortUrl();
            //verifying is it generated short url in DB
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
        //getting redirect url on main page of site with generated short url
        $shortUrlLink = url('/') . '/' . $shortUrl;

        return redirect()->back()->with('shortUrlLink',$shortUrlLink);
    }

    /**
     * redirecting on long url
     * @param $url - short url
     * @return $this|\Illuminate\Http\RedirectResponse - redirect to long url
     */
    public function getUrlRedirect($shortUrl)
    {
        //find url object by short url
        $urlObj = Url::where('short_url',$shortUrl)->first();

        if ($urlObj) {
            //updating count of click on founded url
            Url::where('short_url',$shortUrl)->update([
                'count_clicks' => $urlObj->count_clicks + 1,
            ]);
            //redirecting on long url
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
        //updating short url
        Url::where('id', $input['id'])->update([
            'short_url' =>$input['short_url']
        ]);
        //getting generated url of auth user
        $urls = \Auth::user()->urls()->paginate(5);
        return view('pages.index.table', compact('urls'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View return view with error messeges
     */
    public function getUrlErrorMessage()
    {
        return view('pages.messages.error');
    }
}
