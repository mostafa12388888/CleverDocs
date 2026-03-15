<?php

namespace App\Http\Requests\Form;

use Illuminate\Foundation\Http\FormRequest;
use App\Enum\Form\LayoutStatusEnum;
use App\Enum\Form\LayoutTypeEnum;

class LayoutRequest extends FormRequest
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
     * @throws \ReflectionException
     */
    public function rules(): array
    {
        return [
            "subject" => "required|array",
            "subject.en" => "required|string",
            "subject.ar" => "required|string",
            "status" => "required|string|in:" . implode(",", LayoutStatusEnum::getLocalConstants()),
            "type" => "required|string|in:" . implode(",", LayoutTypeEnum::getLocalConstants()),
            "moduleId" => "required|numeric|exists:modules,id",
            "projectId" => "required|numeric|exists:projects,id",
            "imageId" => "nullable|numeric|exists:files,id",
        ];
    }
}
