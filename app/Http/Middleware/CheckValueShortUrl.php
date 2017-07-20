<?php

namespace App\Http\Middleware;

use Closure;

class CheckValueShortUrl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $input = $request->all();
        $input['short_url'] = str_slug(strip_tags($input['short_url']));
        $request->replace($input);
        return $next($request);
    }
}
