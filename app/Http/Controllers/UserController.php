<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Models\Session;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Store a newly created user in storage.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        // Data is validated, and because the User model has a cast for 'password' => 'hashed',
        // we don't need to manually hash the password here.
        User::create($request->validated());

        return response()->json([
            'data' => 'Ok'
        ]);
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => 'Email sudah terdaftar'
            ], 401);
        }

        Session::create([
            'id_user' => $user->id,
            'token' => Str::uuid()->toString(),
        ]);

        return response()->json([
            'data' => 'Ok'
        ]);
    }

    /**
     * Get the authenticated user.
     */
    public function current(Request $request): JsonResponse
    {
        $user = $request->get('authenticated_user');

        return response()->json([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
            ]
        ]);
    }
}
