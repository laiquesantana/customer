<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'jwtSecret' => getenv('JWT_SECRET_KEY') ?: 'your-secret-key',
    'jwtIssuer' => getenv('JWT_ISSUER') ?: 'http://localhost',
    'jwtAudience' => getenv('JWT_AUDIENCE') ?: 'http://localhost',
    'jwtExpiry' => 3600, // Token validity in seconds
];
