<?php

namespace App\Http\Resources\User;

use App\Enum\Company\AvatarEnum;
use App\Http\Resources\Company\CompanyListSummaryResource;
use App\Http\Resources\FileResource;
use App\Http\Resources\Form\Storeandupdate\FormDataResource;
use App\Http\Resources\Form\Storeandupdate\ProjectResource;
use App\Http\Resources\InputForm\Show\InputFormResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'contactId'=> $this->id,
            'name'=> $this->name ? json_decode($this->name) : null,
            'position'=> $this->position ? json_decode($this->position) : null,
             "isAvatar"=>$this->avatar_id ? true : false,
            "avatar"=>$this->avatar_id? AvatarEnum::findById($this->avatar_id): null,
            "image" =>$this->imageFile?  FileResource::make($this->imageFile) : null,
            'address'=> $this->address ? json_decode($this->address) : null,
            'phone1'=> $this->phone1,
            'phone2'=> $this->phone2,
            "company" => CompanyListSummaryResource::make($this->company),
        ];
    }
}
