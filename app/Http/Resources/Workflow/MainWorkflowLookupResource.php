<?php

namespace App\Http\Resources\Workflow;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MainWorkflowLookupResource extends JsonResource
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
            'mainId' => $this->id,
            "lastVersion" => $lastVersion ? [
                "id" => $lastVersion->id,
                "title" => json_decode($lastVersion->title),
            ] : null,

        ];
    }
}
