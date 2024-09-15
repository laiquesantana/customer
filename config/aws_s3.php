<?php
// config/aws_s3.php
return [
    'credentials' => [
        'key'    => env('AWS_ACCESS_KEY'),
        'secret' => env('AWS_SECRET_KEY'),
    ],
    'region' => env('AWS_REGION', 'us-west-1'),
    'bucket' => env('AWS_BUCKET'),
    'version' => 'latest',
];
