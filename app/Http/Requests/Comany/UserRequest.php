<?php

namespace App\Http\Requests\Comany;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            "projectIds"=>"array",
            "projectIds.*"=>"numeric|exists:projects,id",
            'contactId'=> "required|exists:contacts,id",
            'roleId'=> "required|exists:roles,id",
            'isActive'=> "required|boolean",
            'code' => 'required|string',
            "password"=>"required|string|min:6",
            "email"=>"required|email|unique:users,email",
        ];
    }
}
