<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiRequest;

class RolesRequest extends ApiRequest
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
            'name' => 'required|array',
            'name.en' => 'required|string|unique:roles,name->en,' . $this->id . ',id',
            'name.ar' => 'required|string|unique:roles,name->ar,' . $this->id . ',id',
            'permissions' => 'required|array',
            'permissions.*' => 'required|string|exists:permissions,name',
        ];
    }
}
