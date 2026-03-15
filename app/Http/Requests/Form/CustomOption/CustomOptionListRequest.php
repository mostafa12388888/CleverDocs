<?php

namespace App\Http\Requests\Form\CustomOption;

use Illuminate\Foundation\Http\FormRequest;

class CustomOptionListRequest extends FormRequest
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
            "name"=>"array",
            "name.en"=>"required|string",
            "name.ar"=>"required|string",
            "isActive" => "required|boolean",
        ];
    }
}
