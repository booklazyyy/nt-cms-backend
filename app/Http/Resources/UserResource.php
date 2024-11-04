<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    protected $token;

    public function toArray(Request $request): array
    {
        $this->token = $this->createToken("Token")->plainTextToken;
        return [
            'user_id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'token' => $this->token,
            'roles' => $this->roles,
            'permissions' => $this->permissions,
        ];
    }

    public function withResponse(Request $request, JsonResponse $response): void
    {
        // $this->token = $this->createToken("Token")->plainTextToken;

        // แนบ token ไปใน cookie
        $cookie = cookie('token', $this->token, 60 * 24);
    
        // ส่ง response พร้อม cookie ที่มี token
        $response->withCookie($cookie);
    }
}
