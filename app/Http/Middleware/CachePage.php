<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth\Guard;
use Cache;

/**
 * Taken from Dzuris' comment: https://stackoverflow.com/questions/32880048/cache-entire-html-response-in-laravel-5
 * He also created a Middleware package with more functionality: https://github.com/GlaivePro/CachePage
 */
class CachePage {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $key = $request->fullUrl();  //key for caching/retrieving the response value

        if (Cache::has($key))  //If it's cached...
            return response(Cache::get($key));   //... return the value from cache and we're done.

        $response = $next($request);  //If it wasn't cached, execute the request and grab the response

        $cachingTime = 2;  //Let's cache it for 60 minutes
        Cache::put($key, $response->getContent(), $cachingTime);  //Cache response

        return $response;
    }
}