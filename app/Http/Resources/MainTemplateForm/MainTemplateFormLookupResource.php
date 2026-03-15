<?php

namespace App\Http\Resources\MainTemplateForm;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MainTemplateFormLookupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lastVersion = $this->lastVersion;
        return [
            "id" => $this->id,
            "name" => json_decode($this?->name),
            "lastVersion" => $lastVersion ? [
                "id" => $lastVersion->id,
                "version" => $lastVersion->version,
                "name" => json_decode($lastVersion->name),
                "hasOfficialSignature" => $lastVersion->hasOfficialSignature(),
            ] : null,

        ];
    }
}
