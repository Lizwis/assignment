<?php

namespace App\Repositories\Auth;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Auth\AuthRepositoryInterface;
use App\Models\User;

class AuthRepository implements AuthRepositoryInterface
{

    public function login()
    {
        try {
            $validateUser = Validator::make(
                request()->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt(request()->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'errors' => ["email" => ["Incorret Email or Password !!"]]
                ], 401);
            }

            $user = User::where('email', request()->email)->first();

            return [
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ];
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function register()
    {
        $validateData = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
        ]);

        $validateData['password'] = bcrypt(request('password'));

        $user = User::create($validateData);
        return $user;
    }


    public function logout()
    {
        request()->user()->tokens()->delete();
        return 'user logout successfully';
    }
}
