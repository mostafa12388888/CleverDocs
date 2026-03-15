<?php

namespace App\Http\Requests\Form;

use App\Enum\Form\InputTypeCategoryEnum;
use App\Enum\Form\InputTypeEnum;
use App\Enum\Form\InputTypeOptionEnum;
use Illuminate\Foundation\Http\FormRequest;

class InputTypeRequest extends FormRequest
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
            "title" => "required|array",
            "title.en" => "required|string",
            "title.ar" => "required|string",
            "type" => "required|string|in:" . implode(",", InputTypeEnum::getLocalConstants()),
            "category" => "required|string|in:" . implode(",", InputTypeCategoryEnum::getLocalConstants()),
            "optionsType" => "required_if:type,".InputTypeEnum::RADIO.",". InputTypeEnum::CHECKBOX.",". InputTypeEnum::DROPDOWN."|in:" . implode(",", InputTypeOptionEnum::getLocalConstants()),
            "customListOptionsId" => "nullable|required_if:optionsType,".InputTypeOptionEnum::CUSTOM_LIST."|exists:custom_option_lists,id",
            "entity" => "required_if:optionsType,".InputTypeOptionEnum::ENTITY,
            "isDefault" => "boolean",
        ];
    }
}
