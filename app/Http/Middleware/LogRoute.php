<?php

namespace App\Http\Middleware;

use App\AuditTrails;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LogRoute
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
        $response = $next($request);
        
        $log = [
            'remote_uri' =>  $request->server('REQUEST_URI'),
            'remote_ip' => $request->server('REMOTE_ADDR'),
            'log' => json_encode($request->server()),
        ];
        
        AuditTrails::create($log);

        return $response;
    }
}