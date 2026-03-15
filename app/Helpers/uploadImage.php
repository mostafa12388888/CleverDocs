<?php

use Illuminate\Support\Facades\Storage;


function UploadImage($image,$folderName,$disk){


     $fileName= $image->getClientOriginalName();
      $image->storeAs($folderName, $fileName, $disk);
      return $folderName.'/'.$fileName ;

    }
