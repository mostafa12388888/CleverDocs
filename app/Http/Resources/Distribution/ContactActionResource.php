<?php

namespace App\Http\Resources\Distribution;

use App\Http\Resources\Form\CustomOption\CustomOptionSummaryResource;
use App\Http\Resources\User\UserContactSummaryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactActionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'contact' => new UserContactSummaryResource($this->contact),
            'action'  => new CustomOptionSummaryResource($this->action),
        ];
    }
}
