<?php

namespace App\Http\Requests\Form;

use Illuminate\Foundation\Http\FormRequest;
use App\Enum\Form\InputTypeEnum;


class InputTypeUpdateRequest extends FormRequest
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
            "customListOptionsId" => "exists:custom_option_lists,id",
        ];
    }
}
