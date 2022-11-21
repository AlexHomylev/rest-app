<?php
return [
    'id' => 'frontend',
    'basePath' => dirname(__DIR__),
    'name' => 'frontend.localhost',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'enabled' => true
                ]
            ],
        ],
        'urlManager' => require __DIR__ . '/url-manager.php',
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'formatter' => [
            'dateFormat' => 'dd.MM.yyyy',
        ],
    ],
];
