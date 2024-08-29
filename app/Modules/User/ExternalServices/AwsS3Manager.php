<?php

declare(strict_types=1);

namespace App\Modules\User\ExternalServices;

use Aws\Exception\AwsException;
use Aws\S3\S3Client;
use Illuminate\Http\UploadedFile;

final class AwsS3Manager
{
    private S3Client $s3;

    public function __construct()
    {
       $this->s3 = new S3Client([
            'version' => 'latest',
            'region'  => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ]
        ]);
    }

    public function upload(?UploadedFile $file): ?string
    {
        if (empty($file)) {
            return null;
        }
       try {
        $keyname = 'profile_' . date('d-m-Y') . '-' . time() . '.' . $file->getClientOriginalExtension();
        $this->s3->putObject([
            'Bucket' => env('AWS_BUCKET'),
            'Key'    => $keyname,
            'Body' => fopen($file->path(), 'rb'),
            'SourceFile'   => $file->getPathname(),
            'ContentType'  => $file->getMimeType(),
            'ContentDisposition' => 'inline',
        ]);
            
        return $keyname;
       } catch(AwsException $e) {
        throw new \Exception($e->getMessage());
       }
    }

    public function preSignUrl(?string $fileName = null): ?string
    {
        if(empty($fileName)) {
            return null;
        }
        try {
            $cmd = $this->s3->getCommand('GetObject', [
                'Bucket' => env('AWS_BUCKET'),
                'Key'    => $fileName,
                'ResponseContentDisposition' => 'inline'
            ]);
            $request = $this->s3->createPresignedRequest($cmd, '+60 minutes');
            $presignedUrl = (string) $request->getUri();
            return $presignedUrl;
        } catch(AwsException $e) {
            throw new \Exception($e->getMessage());
        }

    }
}
