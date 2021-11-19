<?php

namespace App\Services\Utils;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LocalFileUploadService
{
    /**
     * @method save(UploadedFile $file, string $path)
     *
     * @param UploadedFile $file
     * @param string $path
     * 
     * @return string
     */
    public function save(UploadedFile $file, string $path): string
    {
        throw_if(
            ! $file->storeAs( $path, $fileName = $this->generateFileName($file)),
            new Exception("File upload failure")
        );

        return $fileName;
    }

    /**
     * @method update(string $currentFileName, UploadedFile $file, string $path)
     *
     * @param string $currentFileName
     * @param UploadedFile $file
     * @param string $path
     * 
     * @return string
     */
    public function update(string $currentFileName, UploadedFile $file, string $path): string
    {
        $this->delete(sprintf('%s/%s', $path, $currentFileName));

        return $this->save($file, $path);
    }

    /**
     * @method delete(string $filePath)
     *
     * @param string $filePath
     * 
     * @return bool
     */
    public function delete(string $filePath): bool
    {
        return Storage::delete($filePath);
    }

    /**
     * Generate file name.
     * @method generateFileName(UploadedFile $file)
     * 
     * @return string
     */
    protected function generateFileName(UploadedFile $file): string
    {
        return $file->hashName();
    }
}