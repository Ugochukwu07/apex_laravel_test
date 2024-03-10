<?php

namespace App\Http\Middleware;

use App\Enums\UserRoleEnum;
use App\Helper\ResponseHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MustBeAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user()->roles == UserRoleEnum::Admin->value)
            return $next($request);

        return ResponseHelper::response('Unauthorized Request', 403, false, 403);
    }
}
