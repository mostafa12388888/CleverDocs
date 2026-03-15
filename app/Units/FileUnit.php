<?php

namespace App\Units;



class FileUnit extends CreateUnit
{
    private mixed $file;
    private string $filePath;

    /**
     * @param array $file
     * @param string $filePath
     */
    public function __construct(mixed $file, string $filePath)
    {
        $this->file = $file;
        $this->filePath = $filePath;

    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $attachment = $this->file;
        if (!$attachment) return [];

        $filepath = $this->filePath;
        return [
            'original_name' => $attachment->getClientOriginalName(),
            'stored_name' => $attachment->getClientOriginalName(),
            'path' => $filepath,
            'mime_type' => $attachment->getMimeType(),
            'extension' => $attachment->getClientOriginalExtension(),
            'size' => $attachment->getSize(),
            'created_at' => now(),
        ];
    }


}
