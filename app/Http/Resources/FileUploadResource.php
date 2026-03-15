<?php

namespace App\Http\Resources;

use App\Helpers\FileHelper;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class FileUploadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'results' => $this->_mapResults(),
            'successCount' => $this->successCount,
            'failedCount' => $this->failedCount,
        ];
    }

    private function _mapResults()
    {
        return collect($this->results)->map(function ($result) {
            return [
                'success' => (bool)($result?->id ?? false),
                'id' => $result?->id ?? null,
                'fullUrl' =>  FileHelper::getDiskFullURL($result?->path ?? null, 'local'),
                'url' => $result?->path ?? null,
                'extension' => $result?->extension ?? null,
                'name' => $result?->original_name ?? null,
                'size' => $result?->size ?? null,
                'mimeType' => $result?->mime_type  ?? null,
                'failedReason' => $result->failedReason ?? null,
            ];
        });
    }
}
