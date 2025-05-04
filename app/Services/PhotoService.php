<?php

namespace App\Services;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PhotoService
{
    public function createPhoto(Request $request): Photo
    {
        $pathImage = Storage::disk('public')->putFile('images', $request->file('photo_path'));

        $photo = new Photo();
        $photo->title = $request->title;
        $photo->photo_path = $pathImage;
        $photo->save();

        return $photo;
    }

    public function updatePhoto(Request $request, Photo $photo): Photo
    {
        $photo->title = $request->title;
        if ($photo->photo_path) {
            Storage::disk('public')->delete($photo->photo_path);
        }
        $pathImage = Storage::disk('public')->putFile('images', $request->file('photo_path'));

        $photo->photo_path = $pathImage;
        $photo->save();
        return $photo;
    }

    public function deletePhoto(Photo $photo): void
    {
        Storage::disk('public')->delete($photo->photo_path);
        $photo->delete();
    }
}
