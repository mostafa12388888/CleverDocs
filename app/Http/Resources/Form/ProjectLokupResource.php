<?php

namespace App\Http\Resources\Form;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectLokupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $wbs=$this->wbs;
        return [
            "id" => $this->id,
            'name' => json_decode($this->name),
            'wbs' => !is_null($wbs)?[
                "id"=>$wbs->id,
                "title"=>json_decode($wbs->title),
            ]:null,

        ];
    }
}
