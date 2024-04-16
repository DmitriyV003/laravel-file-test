<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    private const TOKEN_TYPE = 'bearer';

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function me()
    {
        return new UserResource(auth()->user());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => self::TOKEN_TYPE,
        ]);
    }
}
