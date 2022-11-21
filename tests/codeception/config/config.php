<?php

$s3Host = 'minio';
$dbHost = 'postgres';
$dbName = 'web';

return [
    'components' => [
        'db' => [
            'dsn' => "pgsql:host=$dbHost;dbname=$dbName",
            'username' => 'web',
            'password' => 'web',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        's3Client' => [
            'class' => 'common\components\S3Client',
            'key' => 'minio',
            'secret' => 'minio124',
            'endpoint' => "http://$s3Host:9000",
            'bucket' => 'tempfiles',
        ],
    ],
];
