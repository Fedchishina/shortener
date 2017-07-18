<?php

namespace App\Http\Middleware;

use App\Url;
use Closure;

class CheckEditUrl
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
        $errorText = 'You are trying to edit foreign url';
        if (\Auth::check()) {
            $user = \Auth::user();
            $url = Url::where('id', $input['id'])->first();
            if ($user->id <> $url->user_id) {

                return $next($request);
            } else {
                return redirect('/')->withErrors(array('foreign url' => 'You are trying to edit foreign url'));
            }
        } return redirect('/')->withErrors(array('foreign url' => 'You are trying to edit foreign url'));
    }
}
