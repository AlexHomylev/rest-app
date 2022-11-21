<?php

use common\components\Connection;

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'db' => [
             'class' => Connection::class,
        ],
        'urlManager' => [
            'rules' => [
                '<controller:\w+>' => '<controller>/index',
            ]
        ],
        's3Client' => [
            'class' => 'common\components\S3Client',
            'key' => 'minio',
            'secret' => 'minio124',
            'endpoint' => 'http://localhost:9000',
            'bucket' => 'tempfiles',
        ],
    ],
];
