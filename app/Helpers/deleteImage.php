<?php

use Illuminate\Support\Facades\Storage;


function deleteImage($imagePath, $disk = 'logo')

{

    if(!$imagePath) return false;

    if (Storage::disk($disk)->exists($imagePath)) {
        // Delete the image
        Storage::disk($disk)->delete($imagePath);
        return true; // Image deleted successfully
    }
        return false; // Image not found



}
