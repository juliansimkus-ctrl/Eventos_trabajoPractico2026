<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si no está logueado o no es admin, se corta acá
        if (! $request->user() || ! $request->user()->esAdmin()) {
            abort(403, 'No tenés permiso para entrar acá.');
            }
            
        // Si es admin, la petición sigue su camino hacia el controller
        return $next($request);
    }
}
