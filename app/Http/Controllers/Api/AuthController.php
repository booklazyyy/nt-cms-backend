<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// form request
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Resources\UserResource;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenBlacklistedException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Illuminate\Routing\Controllers\HasMiddleware;

/**
 * @group Authenticate
 *
 * APIs for Authenticate
 */
class AuthController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            // examples with aliases, pipe-separated names, guards, etc:
            // 'role_or_permission:manager|edit articles',
            // new Middleware('permission:delete role', only: ['me']),
            // new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('manager'), except: ['show']),
            // new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete records,api'), only: ['destroy']),
        ];
    }

    /**
     * Sign in a user
     * 
     * Get a JWT via given credentials.
     * @unauthenticated
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {

        try {
            $credentials = $request->only('email', 'password');
            // access token
            // set secert key for token
            JWTAuth::getJWTProvider()->setSecret(env('JWT_ACCESS_SECRET'));
            $access_token = [];
            if (!$access_token['token'] = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => 'Unauthorize',
                    'code' => 401,
                    'message' => 'Invalid credentials!',
                ], 401);
            }
            $access_token['expires_in'] = JWTAuth::factory()->getTTL() * 60;
            // refresh token
            // set secert key for token
            JWTAuth::getJWTProvider()->setSecret(env('JWT_REFRESH_SECRET'));

            $token_validity = (config('jwt.refresh_ttl'));
            JWTAuth::factory()->setTTL($token_validity);

            $refresh_token = [];
            $refresh_token['token'] = JWTAuth::attempt($credentials);
            $refresh_token['expires_in'] = JWTAuth::factory()->getTTL() * 60;

            return $this->respondWithToken($access_token, $refresh_token);
        } catch (JWTException $e) {
            throw new JWTException($e->getMessage(), 401);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Bad Request',
                'code' => 400,
                'message' => $e->getMessage(),
            ], 400);
        }
        // return response()->json(['acc' => $con_acc, 'refre' => $con_refresh]);

    }
    /**
     * Create a new user
     * 
     * @unauthenticated
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        // return response()->json($request->all());

        try {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            $user_role = Role::where('name', 'user')->first();
            $admin_role = Role::where('name', 'admin')->first();
            // $roles_assigned = [];

            if ($user_role) {
                $user->assignRole($user_role);
            }
            if ($admin_role) {
                $user->assignRole($admin_role);
            }

            $roles = $user->roles->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'guard_name' => $role->guard_name,
                    'permissions' => $role->permissions->pluck('name')->toArray(), // ดึงชื่อ permission เท่านั้น
                ];
            });

            $responses = $user->only(['id', 'name', 'email', 'created_at', 'updated_at']);
            $responses['roles'] = $roles;

            // $responses->roles = $user_assigned_roles;

            return response()->json($responses, 201);
            // return $this->respondWithToken($access_token, $refresh_token);
        } catch (QueryException $e) {
            throw new QueryException(
                $e->getConnectionName(),
                $e->getSql(),
                $e->getBindings(),
                $e->getPrevious()
            );
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Internal Server Error',
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
        // return response()->json(['acc' => $con_acc, 'refre' => $con_refresh]);

    }
    /**
     * Get a user
     *
     * This endpoint lets you get a user.
     */
    public function me(Request $request)
    {
        $user = JWTAuth::user();

        // if ($user->can('delete role')) {
        try {
            if (!$user) {
                return response()->json([
                    'error' => 'Not Found',
                    'code' => 404,
                    'message' => 'User not found',
                ], 404);
            }
        } catch (JWTException $e) {
            throw new JWTException($e->getMessage(), 401);
        }
        // $user->roles = $user->getRoleNames();
        $user->roles = $user->getPermissionsViaRoles();

        return response()->json([
            'status' => 'success',
            'users' => $user,
            'check' => JWTAuth::check()
        ]);
        // }

        // return response()->json(['error' => 'user not access!']);


        // return response()->json(JWTAuth::user());
    }
    /**
     * Sign out a user
     *
     * This endpoint lets you logout and destroy a token.
     * @authenticated
     */
    public function logout(Request $request)
    {
        $refresh_token = $request->input('refresh_token');
        // return response()->json(['message' => JWTAuth::user()]);

        JWTAuth::invalidate();
        JWTAuth::getJWTProvider()->setSecret(env('JWT_REFRESH_SECRET'));
        JWTAuth::setToken($refresh_token);
        JWTAuth::invalidate();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out'
        ]);
    }
    /**
     * Refresh Token
     * 
     * Get a new JWT Token via given refresh token and old access token.
     * @authenticated
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {
        try {
            JWTAuth::getJWTProvider()->setSecret(env('JWT_ACCESS_SECRET'));

            if (!JWTAuth::parseToken()->authenticate()) {
                throw new JWTException('Token not authenticated', 401);
            }
            // return response()->json(JWTAuth::getToken()->get());

            $newtoken = JWTAuth::refresh();
            return response()->json([
                'status' => 'success',
                'access_token' => $newtoken
            ]);
        } catch (TokenExpiredException $e) {
            // Access token has expired
            try {
                $newtoken = JWTAuth::refresh();
                return response()->json([
                    'status' => 'success',
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
            return response()->json([
                'error' => 'Internal Server Error',
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    protected function respondWithToken($access_token, $refresh_token)
    {
        $user_id = JWTAuth::user()->id;
        // $user = JWTAuth::user()->roles;
        $user = User::find($user_id);
        // $user = $user->roles;

        $roles = $user->roles->map(function ($role) {
            return [
                'id' => $role->id,
                'name' => $role->name,
                'guard_name' => $role->guard_name,
                'permissions' => $role->permissions->pluck('name')->toArray(), // ดึงชื่อ permission เท่านั้น
            ];
        });

        $response = [
            'status' => 'success',
            'token_type' => 'bearer',
            'access_token' => $access_token,
            'refresh_token' => $refresh_token,
            'user' => $user->only(['id', 'name', 'email', 'created_at', 'updated_at'])
        ];
        $response['user']['roles'] = $roles;
        // $responses['user']['roles']['permissions'] = $user->roles;


        return response()->json($response, 200);
    }
}
