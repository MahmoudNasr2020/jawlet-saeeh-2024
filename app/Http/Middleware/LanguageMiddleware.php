<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasCookie('locale')) {
            $locale = $request->cookie('locale');
            App::setLocale($locale);
        }

        return $next($request);
    }
}
