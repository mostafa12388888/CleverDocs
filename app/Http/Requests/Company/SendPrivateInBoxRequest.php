<?php

namespace App\Http\Requests\Company;

use App\Enum\Form\PrivateInBoxStatusEnum;
use App\Enum\Form\PrivateInBoxTypeEnum;
use App\Enum\Form\PrivateInBoxTypeProjectRequiredEnum;
use Illuminate\Foundation\Http\FormRequest;

class SendPrivateInBoxRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "type" => "required|string|in:".implode(",", PrivateInBoxTypeEnum::getLocalConstants()),
            "typeId" => "required|numeric",
            "projectId" => "required_if:type,".implode(",", PrivateInBoxTypeProjectRequiredEnum::getLocalConstants())."|numeric|exists:projects,id",
            "contactsIds" => "required|array",
            "contactsIds.*" => "numeric|exists:contacts,id",
            "message" => "nullable|string",
        ];
    }
}
