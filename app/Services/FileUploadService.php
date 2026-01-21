<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Throwable;

class FileUploadService
{
    /**
     * Upload a file and return its storage path.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param bool $deleteOld
     * @param string|null $oldPath
     * @return string|null
     */
    public static function upload(UploadedFile $file, string $directory, bool $deleteOld = false, string $oldPath = null): ?string
    {
        try {
            // Prepare filename
            $originalName = $file->getClientOriginalName();

            // Remove and Replaces whitespaces with underscore and Title Case
            $filename = time() . '_' . preg_replace('/\s+/', '_', ucwords(strtolower($originalName)));

            // Store file
            $path = Storage::disk('public')->putFileAs($directory, $file, $filename);

            // Delete old file if required
            if ($deleteOld && $oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            return $filename;
        } catch (Throwable $th) {
            report($th);
            return null;
        }
    }

    /**
     * Delete a file safely.
     *
     * @param string|null $path
     * @return bool
     */
    public static function delete(?string $path): bool
    {
        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        return false;
    }

    /**
     * Get public URL of stored file.
     *
     * @param string|null $path
     * @return string|null
     */
    public static function url(?string $path): ?string
    {
        return $path ? Storage::url($path) : null;
    }
}
