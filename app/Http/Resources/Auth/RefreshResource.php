<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\Form\Storeandupdate\FormDataResource;
use App\Http\Resources\Form\Storeandupdate\ProjectResource;
use App\Http\Resources\InputForm\Show\InputFormResource;
use App\Http\Resources\User\UserContactResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RefreshResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'accessToken'=>$this->accessToken,
            'refreshToken'=>$this->refreshToken,
            'expiresIn'=>$this->expiresIn,

        ];
    }
}
