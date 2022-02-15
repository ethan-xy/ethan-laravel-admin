<?php

namespace Ethan\LaravelAdmin\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function authenticate()
    {
        $config = data_get(config("auth.auth_provider"), request('provider'));
        if (! $config) {
            return response('Undefined provider', 422);
        }

        $user = app($config['model'])->where(function ($query) use ($config) {
            foreach ($config['login_fields'] as $field) {
                $query->orWhere($field, request('username'));
            }
            return $query;
        })->first();

        if (!$user || !Hash::check(request('password'), $user->password)) {
            throw ValidationException::withMessages([
               '请输入正确的用户名和密码'
            ]);
        }

        PersonalAccessToken::query()->where("tokenable_type", $config['model'])
            ->where("name", request('provider'))
            ->where("tokenable_id", $user->id)
            ->delete();

        return response()->json([
            'data' => [
                'token' => $user->createToken(request('provider'))->plainTextToken,
            ]
        ]);
    }

    /**
     * logout
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return true;
    }
}