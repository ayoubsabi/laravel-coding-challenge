<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class LocalFileUploadService
{
    private $file, $fileName;

    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
    }

    /**
     * Save file to a giving path.
     *
     * @param  string $path
     * 
     * @return self
     */
    public function save(string $path)
    {
        $this->file->storeAs($path, $this->generateFileName());

        return $this;
    }

    /**
     * Generate file name.
     * 
     * @return string
     */
    protected function generateFileName()
    {
        return $this->fileName = $this->file->hashName();
    }

    /**
     * Get file name.
     * 
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }
}