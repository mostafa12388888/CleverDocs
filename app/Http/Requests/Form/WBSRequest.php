<?php

namespace App\Http\Requests\Form;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;


class WBSRequest extends ApiRequest
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
           'title'=> 'required|array',
           'title.en'=> 'required|string|min:3',
           'title.ar'=> 'required|string|min:3',
           'parentId'=> 'nullable|integer|exists:w_b_s,id',
        ];
    }
}
