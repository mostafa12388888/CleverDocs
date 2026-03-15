<?php

namespace App\Http\Requests\Distribution;

use Illuminate\Foundation\Http\FormRequest;
use App\Enum\Form\PrivateInBoxTypeEnum;
use App\Enum\Form\PrivateInBoxTypeProjectRequiredEnum;


class DistributionInboxRequest extends FormRequest
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
            "contactsActions" => "required|array",
            "contactsActions.*.id" => "required|exists:contacts,id",
            "contactsActions.*.actionId" => "required|exists:input_options,id",
            "type" => "required|string|in:" . implode(",", PrivateInBoxTypeEnum::getLocalConstants()),
            "typeId" => "required|numeric",
            "projectId" => "required_if:type,".implode(",", PrivateInBoxTypeProjectRequiredEnum::getLocalConstants())."|numeric|exists:projects,id",
            "priorityId" => "required|numeric|exists:input_options,id",
            "distributionListId" => "required|numeric|exists:distribution_lists,id",
            "message" => "nullable|string",
        ];
    }
}
