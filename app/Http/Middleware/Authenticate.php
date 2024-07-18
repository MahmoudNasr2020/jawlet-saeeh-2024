<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{

    protected function redirectTo(Request $request): ?string
    {
        //return $request->expectsJson() ? null : route('login');
        if (! $request->expectsJson()) {
            if (\Illuminate\Support\Facades\Request::is('dashboard/*'))
            {
                return route('dashboard.login.index');
            }
            return route('login');
        }
        return null;
    }
}
