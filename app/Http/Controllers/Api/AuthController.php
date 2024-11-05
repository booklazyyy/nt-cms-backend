<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Response;
use App\Http\Resources\UserResource;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        // if(Auth::user()) {
        //     return response()->json(['faile'=>])
        //     Auth::invalidate();
        // }
        // Auth::invalidate();

        if (!$token = Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials!'], 401);
        }
        $token_validity = (24 * 60);

        Auth::factory()->setTTL($token_validity);
        // return Auth::user();
        // $refresh = Auth::refresh();
        
        return $this->respondWithToken($token);

        // return new UserResource($this->respondWithToken($token));
    }

    public function me()
    {
        // Auth::refresh(true ,true);
        return response()->json(Auth::user());
    }

    public function logout()
    {
        Auth::logout(true);

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        // return Auth::refresh(true, true);
        return $this->respondWithToken(Auth::refresh(true, true));
    }

    protected function respondWithToken($token, $user = null)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'users' => $user
        ];
    }
}
