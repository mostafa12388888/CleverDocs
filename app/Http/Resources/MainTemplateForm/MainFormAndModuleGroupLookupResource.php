<?php

namespace App\Http\Resources\MainTemplateForm;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MainFormAndModuleGroupLookupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "module"=>$this->module ? [
                "id"=>$this->module->id,
                "name"=>$this->module->name,
            ] : [],
            "forms"=>MainFormLookupResource::collection($this->forms),
        ];
    }
}
