<?php
return [
    'id' => 'console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'console\controllers',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => array_merge(
            require __DIR__ . '/../../frontend/config/url-manager.php',
            [
                'baseUrl' => YII_ENV_TEST,
                'scriptUrl' => YII_ENV_TEST,
                'enablePrettyUrl' => true,
                'showScriptName' => false,
                'suffix' => '',
            ]
        ),
    ],
];
