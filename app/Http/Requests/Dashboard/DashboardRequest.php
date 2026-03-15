<?php

namespace App\Http\Requests\Dashboard;

use App\Enum\Dashboard\SettingEnum;
use Illuminate\Foundation\Http\FormRequest;

class DashboardRequest extends FormRequest
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
            "settings" => "required|string|in:" . implode(",", SettingEnum::getLocalConstants()),
            "isDefault" => "boolean",
            'userIds' => 'required_if:settings,' . SettingEnum::PUBLIC . '|array',
            'userIds.*' => 'required_if:settings,' . SettingEnum::PUBLIC . '|exists:users,id',
        ];
    }
}
