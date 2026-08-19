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
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($folder, $filename, 'public');

        return $path;
    }
}
