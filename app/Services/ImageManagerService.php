<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageManagerService
{
    public static function uploadImage(string $base64): ?string
    {
        if (!preg_match('/^data:image\/(\w+);base64,/', $base64, $matches)) return null;

        $extension = strtolower($matches[1]);
        $data = substr($base64, strpos($base64, ',') + 1);
        $decoded = base64_decode($data);

        if ($decoded === false) return null;

        $fileName = 'img-' . now()->format('YmdHis') . '-' . Str::random(8) . '.' . $extension;
        $path = 'image/' . $fileName;

        if (Storage::put($path, $decoded)) return $fileName;
        else return null;
    }

    public static function deleteImage($name): void
    {
        Storage::delete('image/' . $name);
    }
}
