<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Config;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Response;
use App\Http\Resources\UserResource;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenBlacklistedException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;


class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        // if(JWTAuth::user()) {
        //     return response()->json(['faile'=>])
        //     JWTAuth::invalidate();
        // }
        // JWTAuth::invalidate();
        $date = new \DateTime();
        $creadentials = $request->only('email', 'password');

        try {
            // access token
            // set secert key for token
            JWTAuth::getJWTProvider()->setSecret(env('JWT_ACCESS_SECRET'));
            $access_token = [];
            if (!$access_token['token'] = JWTAuth::attempt($creadentials)) {
                return response()->json(['message' => 'Invalid credentials!'], 401);
            }
            $access_token['expires_in'] = JWTAuth::factory()->getTTL() * 60;
            // $token_validity = (24 * 60);

            // refresh token
            // set secert key for token
            JWTAuth::getJWTProvider()->setSecret(env('JWT_REFRESH_SECRET'));

            $token_validity = (config('jwt.refresh_ttl'));
            JWTAuth::factory()->setTTL($token_validity);

            $refresh_token = [];
            $refresh_token['token'] = JWTAuth::attempt($creadentials);
            $refresh_token['expires_in'] = JWTAuth::factory()->getTTL() * 60;
            // date('Y-m-d H:i:s')->modify();
            // $refresh_token = JWTAuth::claims(['is_refresh' => true])->attempt($creadentials);
            // $refresh_token = JWTAuth::fromUser(JWTAuth::user())->setSedcret(config('jwt.refresh_secret'));

            return $this->respondWithToken($access_token, $refresh_token);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token', 'message' => $e->getMessage()], 500);
        }
        // return response()->json(['acc' => $con_acc, 'refre' => $con_refresh]);


        // Get the authenticated user.
        // $user = JWTAuth::user();

        // (optional) Attach the role to the token.
        // $access_token = JWTJWTAuth::setToken($access_token)->claims(['role' => $user->role]);
        // $token_validity = (24 * 60);

        // JWTAuth::factory()->setTTL($token_validity);

        // return new UserResource($this->respondWithToken($access_token));
    }

    public function me(Request $request)
    {
        try {
            if (! $user = JWTAuth::user()) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => $e, 'message' => 'Invalid token'], 400);
        }
        $user->roles = $user->getRoleNames();
        // $cookie = $request->cookie('refresh_token');
        return response()->json(['users' => $user, 'check' => JWTAuth::check()]);

        // return response()->json(JWTAuth::user());
    }

    public function logout(Request $request)
    {
        $refresh_token = $request->cookie('refresh_token');
        // return response()->json(['message' => JWTAuth::user()]);

        JWTAuth::invalidate();
        JWTAuth::getJWTProvider()->setSecret(env('JWT_REFRESH_SECRET'));
        JWTAuth::setToken($refresh_token);
        JWTAuth::invalidate();

        Cookie::forget('refresh_token');

        return response()->json(['message' => 'Successfully logged out'])->withoutCookie('refresh_token');
    }

    public function refresh(Request $request)
    {
        try {

            JWTAuth::getJWTProvider()->setSecret(env('JWT_ACCESS_SECRET'));

            if (!JWTAuth::parseToken()->authenticate()) {
                return response()->json("", 401);
            }

            // return response()->json(JWTAuth::getToken()->get());

            $newtoken = JWTAuth::refresh();
            return response()->json([
                'success' => true,
                'access_token' => $newtoken
            ]);
        } catch (TokenExpiredException $e) {
            // Access token has expired
            try {
                $newtoken = JWTAuth::refresh();
                return response()->json([
                    'success' => true,
                    'access_token' => $newtoken
                ]);
            } catch (TokenExpiredException $e) {
                // Refresh token has expired
                return response()->json([
                    "message" => $e->getMessage()
                ], 401);
            } catch (TokenBlacklistedException $e) {
                // Access token has be list to blacklist. You must re-log into the system.
                return response()->json([
                    "message" => $e->getMessage()
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([], 400);
        }

    }

    protected function respondWithToken($access_token, $refresh_token)
    {
        return response()->json([
            'token_type' => 'bearer',
            'access_token' => $access_token,
            'refresh_token' => $refresh_token,
            'user' => JWTAuth::user()
        ], 200)->withCookie(cookie('refresh_token', $refresh_token['token'], config('jwt.refresh_ttl'), NULL, NULL, false, true));
    }
}
