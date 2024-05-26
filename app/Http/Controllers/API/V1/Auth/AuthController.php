<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

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
            'user' => $user,
            'token' => $user->createToken('auth_token', ['*'], now()->addMonth())->plainTextToken
        ]);
    }

    public function login()
    {

    }

    public function logout()
    {

    }
}
