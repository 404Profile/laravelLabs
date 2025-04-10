<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogVisit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $visit = new Visit();
        $visit->visited_at = Carbon::now();
        $visit->webpage = $request->url();
        $visit->ip_address = $request->ip();
        $visit->host_name = gethostbyaddr($request->ip());
        $visit->browser = $request->header('User-Agent');
        $visit->save();

        return $next($request);
    }
}
