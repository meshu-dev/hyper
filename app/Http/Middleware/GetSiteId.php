<?php

namespace App\Http\Middleware;

use App\Enums\SiteEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GetSiteId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $siteId = SiteEnum::fromKey($request->site)->value;
        $request->merge(['siteId' => $siteId]);

        return $next($request);
    }
}
