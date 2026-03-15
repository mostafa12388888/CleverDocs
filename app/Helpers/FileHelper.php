<?php

namespace App\Helpers;


use Illuminate\Http\UploadedFile;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class FileHelper {


    /**
     * @param UploadedFile $file
     * @param string $filePath
     * @return string|bool
     */
    static function uploadFile(UploadedFile $file, string $filePath): string|bool
    {
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '_' . Str::uuid() . '.' . $extension;
        $path = '/' .  env('APP_STORAGE') . $filePath;

        // Determine the MIME type of the file
        $mimeType = $file->getMimeType();

        if(Storage::disk(config('filesystems.default'))->putFileAs($path, $file, $filename, ['visibility' => 'public', 'mimetype' => $mimeType])) {

            return str_replace('/public', '', $path . '/' . $filename);
        }

        return false;
    }


    /**
     * @param string|null $directoryPath
     * @param string $disk
     * @return string|null
     */
    static function getDiskFullURL(?string $directoryPath, string $disk='local'): ?string
    {
        if(!$directoryPath) return null;
        if ($disk == 'local')
        return env('APP_URL') . 'storage' .$directoryPath;


        return Storage::disk($disk)->url($directoryPath);
    }


}
