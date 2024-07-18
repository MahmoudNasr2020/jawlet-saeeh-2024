<?php

namespace App\Http\Trait;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
trait ImageTrait
{
    public function imageUpload($folder,$image)
    {
        $image_name = time().$image->hashName();
        $image->storeAs($folder,$image_name);
        return $folder .'/'.$image_name;
    }

    public function deleteImage($imagePath)
    {
        $filePath = public_path('images/' . $imagePath);

        if (File::exists($filePath) && !Str::contains($filePath, 'default.png')) {
            File::delete($filePath);
        }
    }
}
