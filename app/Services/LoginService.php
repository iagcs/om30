<?php

namespace App\Services;

use App\DTO\LoginData;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class LoginService
{
    public function login(LoginData $data): User
    {
        $user = User::query()
            ->where('email', $data->email)
            ->where('password', $data->password)
            ->first();

        abort_if(!$user, Response::HTTP_BAD_REQUEST, 'Usuario nao cadastrado');

        $user->tokens()->delete();

        return $user;
    }
}
