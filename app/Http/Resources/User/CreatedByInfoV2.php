<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Form\Storeandupdate\FormDataResource;
use App\Http\Resources\Form\Storeandupdate\ProjectResource;
use App\Http\Resources\InputForm\Show\InputFormResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreatedByInfoV2 extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'userId' => $this?->created_by_id,
            "contactId" => $this?->created_by_contact_id,
            'name'=> json_decode($this?->created_by_contact_name),
        ];
    }
}
