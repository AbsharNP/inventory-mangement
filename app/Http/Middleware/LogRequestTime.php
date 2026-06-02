<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogRequestTime
{
    /**
     * Log every API request's method, endpoint, and execution time.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $start = microtime(true);

        $response = $next($request);

        $duration = round((microtime(true) - $start) * 1000, 2);

        Log::info('API Request', [
            'method'   => $request->method(),
            'endpoint' => $request->path(),
            'status'   => $response->getStatusCode(),
            'duration' => "{$duration}ms",
            'ip'       => $request->ip(),
            'user_id'  => $request->user()?->id,
        ]);

        return $response;
    }
}
