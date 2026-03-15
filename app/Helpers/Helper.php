<?php

namespace App\Helpers;


use Illuminate\Http\UploadedFile;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class Helper {
    /**
     * @param UploadedFile $file
     * @param string $filePath
     * @return string|bool
     */
    static  function isJson($string): bool|string
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

}
