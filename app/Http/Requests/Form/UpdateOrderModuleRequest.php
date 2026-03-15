<?php

namespace App\Http\Requests\Form;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderModuleRequest extends FormRequest
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
            "moduleData"=> "required|array",
            "moduleData.*"=>"required|array",
            "moduleData.*.order"=>"required|numeric",
            "moduleData.*.moduleId"=> "required|numeric|exists:modules,id",

        ];
    }
}
