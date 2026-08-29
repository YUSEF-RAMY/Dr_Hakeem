<?php

namespace App\Actions\Diagnosis;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SaveUploadedImageAction
{
    /**
     * Save an uploaded file to storage disk under diagnoses directory.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @return string Relative path stored on disk
     */
    public function execute(UploadedFile $file, string $folder = 'diagnoses'): string
    {
        $extension = $file->getClientOriginalExtension();
        if (empty($extension)) {
            $extension = $file->guessExtension() ?: 'png';
        }

        $filename = Str::uuid() . '.' . ltrim($extension, '.');
        $path = $file->storeAs($folder, $filename, ['disk' => 'public', 'visibility' => 'public']);

        $fullPath = Storage::disk('public')->path($path);
        if (file_exists($fullPath)) {
            @chmod($fullPath, 0644);
        }

        return $path;
    }
}
