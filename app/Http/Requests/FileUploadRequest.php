<?php

namespace App\Http\Requests;

use App\Enum\FileExtensionEnum;

class FileUploadRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'files' => 'required|array|min:1',
            'files.*' => ['required', 'distinct', function ($attribute, $value, $fail) {
                if (!(in_array($value->extension(), FileExtensionEnum::getLocalConstants())) && !(in_array($value->getClientOriginalExtension(), FileExtensionEnum::getLocalConstants()))) {
                    $fail(__('validation.messages.file_extensions_not_provided_or_exceed_max_size'));
                }
            }],
        ];
    }
}
