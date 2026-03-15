<?php

namespace App\Http\Resources\Form;

use App\Http\Resources\InputForm\FormInputDetailsResource;
use App\Http\Resources\User\CreatedByInfo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        'mainData'=> [
            "id" => $this->id,
            'name'=> json_decode($this->name),
            'layout'    => $this->layout,
            'status' => $this->status,
            'primary' => $this->Primary,
            "moduleId"=>$this->mainTemplateForm->module_id,
            'projects' =>$this->project? ProjectNamesResource::collection($this->project):[],
            'version' => $this->version,
            'symbol' => $this->symbol, //@TODO: add migration for this in database, and in fillable array
            'mainCreatedAt' => $this->mainTemplate?->created_at,
            'createdBy' => new CreatedByInfo($this->mainTemplate?->createdBy),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'updatedBy' => new CreatedByInfo($this->createdBy),
        ],
            'inputs' => FormInputDetailsResource::collection($this->templateInputs),
            "permissions" => [
                "canEdit"=>true,
                "canDelete"=> true
            ]
        ];
    }
}
