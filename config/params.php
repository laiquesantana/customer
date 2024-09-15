<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'jwtSecret' => getenv('JWT_SECRET_KEY') ?: 'your-secret-key',
    'jwtIssuer' => getenv('JWT_ISSUER') ?: 'http://localhost',
    'jwtAudience' => getenv('JWT_AUDIENCE') ?: 'http://localhost',
    'jwtExpiry' => getenv('JWT_EXPIRY') ?: 3600,
    'aws_s3' => [
        'key' => getenv('AWS_ACCESS_KEY') ?: 'default-key',
        'secret' => getenv('AWS_SECRET_KEY') ?: 'default-secret',
        'region' => getenv('AWS_REGION') ?: 'us-east-1',
        'version' => getenv('AWS_VERSION') ?: 'latest',
        'bucket' => getenv('AWS_BUCKET') ?: 'default-bucket',
    ],
];
