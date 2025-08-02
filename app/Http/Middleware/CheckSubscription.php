<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        if (!$user->canAccessDashboard()) {
            return response()->json([
                'error' => 'Necesitas una suscripción activa para acceder a esta funcionalidad',
                'requires_subscription' => true
            ], 403);
        }

        return $next($request);
    }
}
