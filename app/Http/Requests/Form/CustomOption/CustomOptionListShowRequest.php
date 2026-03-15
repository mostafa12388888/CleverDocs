<?php

namespace App\Http\Requests\form\CustomOption;

use Illuminate\Foundation\Http\FormRequest;

class CustomOptionListShowRequest extends FormRequest
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
            "listKey"=> "required_without:listId",
            "listId"=> "required_without:listKey",
        ];
    }
}
