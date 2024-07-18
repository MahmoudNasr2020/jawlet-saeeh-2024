<?php

namespace App\Http\Middleware;

use App\Http\Trait\ApiTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserVerify
{
    use ApiTrait;
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('api')->user()->verify != 1)
        {
            return $this->response('','This account is inactive',401);
        }
        return $next($request);
    }
}
