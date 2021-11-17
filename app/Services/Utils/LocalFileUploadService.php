<?php

namespace App\Services\Utils;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LocalFileUploadService
{
    /**
     * Save file to a giving path.
     *
     * @param  string $path
     * 
     * @return string|false
     */
    public function save(UploadedFile $file, string $path): ?string
    {
        if (!$file->storeAs( $path, $fileName = $this->generateFileName($file))) {
            return false;
        }

        return $fileName;
    }

    /**
     * Update file.
     *
     * @param  string $path
     * 
     * @return string|false
     */
    public function update(UploadedFile $file, string $path, string $currentFileName): ?string
    {
        $this->delete(sprintf('%s/%s', $path, $currentFileName));
        
        if (! $file->storeAs( $path, $newFileName = $this->generateFileName($file))) {
            return false;
        }

        return $newFileName;
    }

    /**
     * Delete the file at a given path.
     *
     * @param  string $filePath
     * 
     * @return bool
     */
    public function delete(string $filePath): bool
    {
        return Storage::delete($filePath);
    }

    /**
     * Generate file name.
     * 
     * @return string
     */
    protected function generateFileName(UploadedFile $file): string
    {
        return $file->hashName();
    }
}