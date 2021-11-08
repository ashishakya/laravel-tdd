<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginController
{
    public function __invoke(LoginRequest $loginRequest)
    {
        $user = User::where("email", $loginRequest->email)->first();

        if ( !$user || !Hash::check($loginRequest->password, $user->password)) {
            return response("Credential do not match", Response::HTTP_UNAUTHORIZED);
        }

        return response(["token" => 'asd']);
    }
}
