<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegistrationController
{
    public function __invoke(RegistrationRequest $request)
    {
        return User::create($request->validated());
    }
}
