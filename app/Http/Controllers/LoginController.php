<?php

namespace App\Http\Controllers;

use App\DTO\LoginData;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Services\LoginService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct(private readonly LoginService $service) {}

    public function login(LoginRequest $request): LoginResource
    {
        return LoginResource::make($this->service->login(LoginData::from($request->validated())));
    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return new JsonResponse(NULL, 204);
    }
}
