<?php

namespace App\Manager;

use Aws\Result;
use Aws\S3\S3Client;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileManager
{
    private $targetDirectory;
    private $bucketName;
    private S3Client $s3Client;
    private $slugger;


    public function __construct($targetDirectory, $bucketName, S3Client $s3Client, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->bucketName = $bucketName;
        $this->s3Client = $s3Client;
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = $this->getFileName($file);
        $file->move($this->targetDirectory,$fileName);
        $filePath = $this->targetDirectory . $fileName;
        $filePut = $this->s3Put($fileName, $filePath);
        unlink($filePath);
        return $filePut->get('ObjectURL');
    }

    private function getFileName(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        return $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
    }

    private function s3Put(string $key, string $filePath): Result
    {
        return $this->s3Client->putObject([
            'Bucket' => $this->bucketName,
            'Key' => 'car/img'.$key,
            'SourceFile' => $filePath,
        ]);
    }
}