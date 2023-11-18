<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read \App\Models\User $resource
 */
class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $token = $this->resource->createToken(name: 'om30_token', expiresAt: now()->addMinutes((int) config('sanctum.expiration')));

        return [
            'id'           => $this->resource->id,
            'name'         => $this->resource->name,
            'email'        => $this->resource->email,
            'access_token' => $token->plainTextToken,
            'expires_in'   => $token->accessToken->expires_at->diffInSeconds(),
            'created_at'   => $this->resource->created_at->toW3cString(),
            'updated_at'   => $this->resource->updated_at->toW3cString(),
        ];
    }
}
