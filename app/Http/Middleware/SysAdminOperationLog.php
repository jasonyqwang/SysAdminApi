<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\SysAdminLogService;

class SysAdminOperationLog
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
        SysAdminLogService::initRequestData();
        return $next($request);
    }
}
