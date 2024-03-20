<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\Auth\ChangeProfileRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Services\AuthService;
use App\Modules\Iam\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Handler for Authentication
 *
 * login, refresh token, profil, etc
 *
 * References:
 *
 * @link https://jwt-auth.readthedocs.io/en/develop/quick-start/
 * @link https://stackoverflow.com/a/77209672
 */
class AuthController extends Controller
{
    /**
     * Login dengan kembalian token
     */
    public function login(LoginRequest $request): JsonResponse
    {
        // generate token
        $credentials = $request->only(['username', 'password']);

        $token = Auth::guard('api')->attempt($credentials);

        // gagal login
        if (! $token) {
            return ResponseHelper::conflict('The username and password not match');
        }

        // retrun token
        return $this->respondWithToken($token);
    }

    /**
     * Mendapatkan profil dari pengguna
     */
    public function me(): JsonResponse
    {
        $user = Auth::guard('api')->user();

        return ResponseHelper::successWithData(new UserResource($user), 'Profile successful fetched');
    }

    /**
     * Mendapatkan profil dari pengguna
     */
    public function changeProfile(ChangeProfileRequest $request): JsonResponse
    {
        $user = Auth::guard('api')->user();

        $response = AuthService::changeProfile($request->validated(), $user);
        if ($response) {
            return ResponseHelper::successWithData(new UserResource($user), 'Profile berhasil di update');
        }

        return ResponseHelper::badRequest('Profile gagal di update');
    }

    /**
     * Melakukan refresh token, ketika sudah expired
     */
    public function refresh(): JsonResponse
    {
        /** @var Illuminate\Auth\AuthManager */
        $auth = Auth::guard('api');

        return $this->respondWithToken($auth->refresh());
    }

    /**
     * Logout dari aplikasi
     */
    public function logout(): JsonResponse
    {
        auth('api')->logout();

        return ResponseHelper::successWithData(null, 'Successfully logged out');
    }

    /**
     * Generate response token
     */
    protected function respondWithToken($token): JsonResponse
    {
        /** @var Illuminate\Auth\AuthManager */
        $auth = Auth::guard('api');

        return ResponseHelper::successWithData([
            'accessToken' => $token,
            'tokenType' => 'bearer',
            'user' => new UserResource($auth->user()),
            'expiresIn' => time() + ($auth->factory()?->getTTL() * 60),
        ]);
    }
}
