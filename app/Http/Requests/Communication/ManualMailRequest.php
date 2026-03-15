<?php

namespace App\Http\Requests\Communication;

use App\Enum\Form\InputOption\InputOptionEnum;
use Illuminate\Foundation\Http\FormRequest;

class ManualMailRequest extends FormRequest
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
            'toContactIds' => ['required', 'array'],
            'toContactIds.*' => ['required','exists:contacts,id'],
            'ccContactIds' => ['nullable', 'array'],
            'ccContactIds.*' => ['nullable','exists:contacts,id'],
            'priority' => ['nullable', 'string', 'in:'. implode(',', [InputOptionEnum::HIGH,InputOptionEnum::LOW,InputOptionEnum::NORMAL])],
            'body' => ['required', 'string'],
            "typeId"=>"required|exists:form_submissions,id"
        ];
    }
}
