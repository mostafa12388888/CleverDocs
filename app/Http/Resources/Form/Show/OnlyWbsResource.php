<?php

namespace App\Http\Resources\Form\Show;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OnlyWbsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'createBy' => $this->create_by,
            'title' =>json_decode( $this->title),
            'wbsId' => $this->id,
            'parentId' => $this->w_b_s_id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
