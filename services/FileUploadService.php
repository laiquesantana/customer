<?php

namespace app\services;
namespace app\services;

use Aws\S3\S3Client;
use League\Flysystem\Filesystem;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use yii\web\UploadedFile;

class FileUploadService
{
    protected Filesystem $filesystem;

    public function __construct()
    {
        $client = new S3Client([
            'credentials' => [
                'key' => \Yii::$app->params['aws_s3']['key'],
                'secret' => \Yii::$app->params['aws_s3']['secret'],
            ],
            'region' => \Yii::$app->params['aws_s3']['region'],
            'version' => \Yii::$app->params['aws_s3']['version'],
        ]);

        $adapter = new AwsS3Adapter($client, \Yii::$app->params['aws_s3']['bucket']);
        $this->filesystem = new Filesystem($adapter);
    }

    public function upload(UploadedFile $file, string $path): string
    {
        $filename = $path . '/' . $file->baseName . '.' . $file->extension;
        $stream = fopen($file->tempName, 'r+');

        $this->filesystem->writeStream($filename, $stream);
        fclose($stream);

        return $filename;
    }
}
