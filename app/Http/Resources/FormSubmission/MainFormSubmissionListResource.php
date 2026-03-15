<?php

namespace App\Http\Resources\FormSubmission;

use App\Http\Resources\Form\FormSummaryResource;
use App\Http\Resources\GenericIdNameResource;
use App\Http\Resources\User\CreatedByInfo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MainFormSubmissionListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        GenericIdNameResource::setColumns([
            [
                'viewKey' => 'inputTypeId',
                'modelKey' => 'id'
            ],
            [
                'viewKey' => 'inputTypeTitle',
                'modelKey' => 'title'
            ],
            [
                'viewKey' => 'inputTypeCategory',
                'modelKey' => 'category'
            ],
            [
                'viewKey' => 'key',
                'modelKey' => 'key'
            ]
        ]);
        FormSubmissionListResource::setInputTypes($this->formInputTypes);
        $resourceCollection = FormSubmissionListResource::collection($this->allSubmissionsData);
        $resourcePagination = $this->formatPagination($resourceCollection, $this->allSubmissionsData);

        return [
            'inputTypes' => GenericIdNameResource::collection($this->formInputTypes),
            'formSubmissions' => $resourcePagination,
        ];
    }


    public function formatPagination(object $data, object $paginator): array
    {
        return [
            'items' => $data,
            "pagination" => [
                'total' => $paginator->total(),
                'currentPage' => $paginator->currentPage(),
                'perPage' => $paginator->perPage(),
                'totalPages' => $paginator->lastPage(),
            ]
        ];
    }
}
