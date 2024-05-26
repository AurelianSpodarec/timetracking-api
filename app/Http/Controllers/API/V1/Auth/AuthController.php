<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\AuthenticatedUserResource;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    use HttpResponses;

    public function register(StoreUserRequest $request) : JsonResponse
    {
        $request->validated($request->only(['name', 'email', 'password', 'username']));

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'username'     => $request->username,
            'password'  => Hash::make($request->password)
        ]);

        return $this->success([
            'user' => new AuthenticatedUserResource($user),
            'token' => $user->createToken('auth_token', ['*'], now()->addMonth())->plainTextToken
        ]);
    }

    public function login(LoginUserRequest $request): JsonResponse
    {
        $request->validated($request->only(['email', 'password']));

        if(!Auth::attempt($request->only(['email', 'password']))) {
            return $this->error('', 'Credentials do not match', 401);
        }

        $user = User::where('email', $request->email)->first();

        return $this->success([
            'user' => new AuthenticatedUserResource($user),
            'token' => $user->createToken('auth_token')->plainTextToken
        ]);
    }

    public function logout(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->success([
            'message' => 'You have successfully been logged out and your token has been removed'
        ]);
    }
}
