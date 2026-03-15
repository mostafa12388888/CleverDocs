<?php

namespace App\Http\Requests\Dashboard;

use App\Enum\Dashboard\ChartTypeEnum;
use App\Enum\Dashboard\CountOrGroupByChartEnum;
use App\Rules\Dashboard\CountOrGroupByRule;
use Illuminate\Foundation\Http\FormRequest;

class ComponentRequest extends FormRequest
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
            "title" => "required|array",
            "title.en" => "required|string",
            "title.ar" => "required|string",
            'isPrivate' => 'boolean',
            'formId' => "required|exists:main_template_forms,id",
            'dashboardId' => "required|exists:dashboards,id",
            "chartType" => "required|string|in:" . implode(",", ChartTypeEnum::getLocalConstants()),
            'countBy' => ['required', 'string', 'max:255', new CountOrGroupByRule()],
            'groupBy' => ['nullable', 'string', 'max:255', new CountOrGroupByRule()],
            'colorRecord' => 'nullable|array',
            'filters' => 'nullable|array',
            'filters.*' => 'required',
        ];
    }
}
