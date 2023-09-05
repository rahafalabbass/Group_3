<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait uploadImage
{
    public function uploadImage($image, $folder,$baseFolder)
    {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs( $imageName,$folder, $baseFolder);

        return $imageName;
    }
}
?>
