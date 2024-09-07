<?php

namespace App\Traits;


trait PhotoUploadTrait
{


  public function saveImage($photo)
 {

    $path = $photo->store('photos', 'public');
    $photo_name = basename($path);
    $jsonImagePaths = json_encode($photo_name);


    return $jsonImagePaths;



 }
}
