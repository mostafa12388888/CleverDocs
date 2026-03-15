<?php

namespace App\Http\Requests\Comany;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPasswordRequest extends FormRequest
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
            'newPassword' => 'required|string|min:6',
            'confirmPassword' => 'required|string|same:newPassword',
            "oldPassword"=> "required|string",
        ];
    }
}
