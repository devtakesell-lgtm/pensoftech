<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HandlesImageUploads
{
    /**
     * Handle the image upload using Laravel 13's native fluent image API.
     *
     * @param  UploadedFile|null  $file  The uploaded image file
     * @param  string  $folder  The folder to store the image in (e.g., 'industries')
     * @param  int  $width  The max width to scale the image to
     * @param  string|null  $oldImage  The path of the old image to delete
     * @return string|null The path to the saved image, or null if no file
     */
    protected function handleImageUpload(?UploadedFile $file, string $folder = 'images', int $width = 800, ?string $oldImage = null): ?string
    {
        if (! $file) {
            return $oldImage;
        }

        // Delete the old image if it exists
        if ($oldImage && Storage::disk('public')->exists($oldImage)) {
            Storage::disk('public')->delete($oldImage);
        }

        // Use Intervention Image to resize and convert
        $image = \Intervention\Image\Laravel\Facades\Image::decode($file);
        $image->scaleDown(width: $width);

        $filename = uniqid() . '_' . time() . '.webp';
        $path = $folder . '/' . $filename;
        
        $encoded = $image->encode(new \Intervention\Image\Encoders\WebpEncoder(80));
        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
    }

    /**
     * Delete an image from storage.
     *
     * @param  string|null  $path  The path of the image to delete
     */
    protected function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
