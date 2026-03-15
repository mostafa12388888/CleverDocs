<?php

namespace App\Http\Resources\MainTemplateForm;

use App\Http\Resources\Form\FormListResource;
use App\Http\Resources\Form\ModuleResource;
use App\Http\Resources\Form\templateFormDetailsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use function PHPUnit\Framework\isNull;

class MainFormDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'mainId' => $this->id,
            "module"=> !is_null($this->modules)?ModuleResource::make($this->modules):null,
            'form' => !is_null($this->lastVersion)? FormListResource::make($this->lastVersion):null,
            'forms'=>templateFormDetailsResource::collection($this->templateForm),
            "permissions" => [
                "canEdit"=>true,
                "canDelete"=> true
            ]
        ];
    }
}
