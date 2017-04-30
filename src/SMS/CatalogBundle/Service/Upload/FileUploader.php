<?php

namespace SMS\CatalogBundle\Service\Upload;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    /**
     * The destination folder.
     *
     * @var string
     */
    private $targetDir;

    /**
     * Initializes the destination folder.
     *
     * @param $targetDir
     */
    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    /**
     * Uploads the file.
     *
     * This method generates a unique name for the file and
     * moves it to the directory.
     *
     * @param UploadedFile $file
     * 
     * @return string
     */
    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();
        $file->move($this->targetDir, $fileName);
        return $fileName;
    }
}
