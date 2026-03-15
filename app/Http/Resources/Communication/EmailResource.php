<?php

namespace App\Http\Resources\Communication;

use App\Http\Resources\Company\ContactLookupResource;
use App\Http\Resources\User\CreatedByInfo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "body" => json_decode($this->body),
            "priority" => $this->priority,
            "typeId" => $this->type_id,
            "createdBy" => CreatedByInfo::make($this->createdBy),
            "ccContact"=>ContactLookupResource::collection($this->ccRecipients),
            "toContact"=>ContactLookupResource::collection($this->toRecipients),
        ];
    }
}
