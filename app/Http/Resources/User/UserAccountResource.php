<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Form\Storeandupdate\FormDataResource;
use App\Http\Resources\Form\Storeandupdate\ProjectResource;
use App\Http\Resources\InputForm\Show\InputFormResource;
use App\Http\Resources\User\UserContactResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user'=>$this->user,
            'contact'=> new UserContactResource($this->user?->contact),
        ];
    }
}
