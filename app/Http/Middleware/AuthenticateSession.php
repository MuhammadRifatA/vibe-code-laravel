<?php

namespace App\Http\Middleware;

use App\Models\Session;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'error' => 'Unauthorize'
            ], 401);
        }

        $session = Session::where('token', $token)->first();

        if (!$session) {
            return response()->json([
                'error' => 'Unauthorize'
            ], 401);
        }

        $user = User::find($session->id_user);

        if (!$user) {
            return response()->json([
                'error' => 'Unauthorize'
            ], 401);
        }

        // Merge the user into the request attributes for easy access in controllers
        $request->merge(['authenticated_user' => $user]);

        return $next($request);
    }
}
