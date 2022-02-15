<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Exceptions\UnauthorizedException;

class EthanAuthCanPermission
{
    public function handle($request, \Closure $next)
    {
        $permission = Route::currentRouteName();

        if (Auth::user()->can($permission)) {
            return $next($request);
        }

        throw UnauthorizedException::forPermissions([$permission]);
    }
}