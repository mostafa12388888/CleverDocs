<?php

namespace App\Http\Resources;

use App\Helpers\FileHelper;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class FileResource extends JsonResource
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
            'id' => $this->id,
            'fullUrl' => FileHelper::getDiskFullURL($this->path, 'local'),
            'originalName' => $this->original_name,
            'storedName' => $this->stored_name,
            'path' => $this->path,
            'mimeType' => $this->mime_type,
            'size' => $this->size,
            'extension' => $this->extension,
            'createdAt' => $this->created_at,
        ];
    }
}
