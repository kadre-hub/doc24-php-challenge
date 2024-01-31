<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    public function handle($request, \Closure $next, ...$guards)
    {
        $token = $request->bearerToken();

        // Validar que el token no esté vacío.
        if (!$token) {
            return response()->json([
                'success' => false,
                'error' => 'No token provided'
            ], 401);
        }

        // Validar el token JWT.
        try {
            $user = Auth::guard('api')->authenticate($request);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid token'
            ], 401);
        }

        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized'
            ], 401);
        }

        return parent::handle($request, $next, ...$guards);
    }
}
