<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "userEmail"=>$this->email,
            'acountCode'=>$this->acount_code,
            'code'=>$this->code,
            'contactId'=>$this->contact_id,
        ];
    }
}
