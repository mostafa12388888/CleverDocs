<?php

namespace App\Http\Resources\CompanyAbout;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginHistoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $currentTokenId = optional($request->user()?->token())->id;
        return [
            "id" => $this->id,
            "tokenId" => $this->token_id,
            "userId" => $this->user_id,
            "logoutAt" => $this->logged_out_at,
            "ip" => $this->ip,
            "location" => $this->location,
            "os" => $this->os,
            "device" => $this->device,
            "browser" => $this->browser,
            "status" => $this->status,
            "expiresAt" => $this->expires_at,
            "createdAt" => $this->created_at,
            'updatedAt' => $this->updated_at,
            "isCurrent" => $this->token_id === $currentTokenId,
        ];
    }
}
