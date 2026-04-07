<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

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
}
