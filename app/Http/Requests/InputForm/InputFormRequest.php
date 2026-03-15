<?php

namespace App\Http\Requests\InputForm;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiRequest;

class InputFormRequest extends ApiRequest
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
            '*.styles'=>'required',
           
            '*.type'=>'required|string',
           '*.x'=>'required|integer',
           '*.y'=>'required|integer',
           '*.title'=>'required|string',
            '*.isMondatory'=>'required|boolean',
           '*.height'=>'required|integer',
           '*.width'=>'required|integer',
            '*.templatesFormId'=>'required|integer',
            '*.inputId'=>'required|integer',
        ];
    }
}
