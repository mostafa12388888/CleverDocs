<?php

namespace App\Http\Requests\Company;

use App\Enum\Company\AvatarEnum;
use Illuminate\Foundation\Http\FormRequest;

class AvatarRequest extends FormRequest
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
            'avatarId' => ['required','integer','in:' . implode(',', AvatarEnum::ids())],
        ];
    }
}
