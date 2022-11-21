<?php

return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'enableStrictParsing' => true,
    'rules' => [
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'rest/adaptation-answers',
            'pluralize' => false,
            'tokens' => [
                '{id}' => '<id:\\w[\\w-,]*>', // UUID
            ],
            'patterns' => [
                'GET {id}' => 'view',
                'GET' => 'index',
                'POST {id}' => 'create',
                '{id}' => 'options',
                '' => 'options',
            ],
        ],
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'rest/adaptation',
            'pluralize' => false,
            'tokens' => [
                '{id}' => '<id:\\w[\\w-,]*>', // UUID
            ],
            'patterns' => [
                'GET {id}' => 'view',
                'POST {id}/answers' => 'create-answer',
                'OPTIONS {id}/answers' => 'options',
            ],
        ],
        '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
    ]
];
