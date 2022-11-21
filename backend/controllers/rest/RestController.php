<?php

namespace backend\controllers\rest;

use common\helpers\ArrayHelper;
use yii\rest\ActiveController;

class RestController extends ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return ArrayHelper::merge($behaviors, [
            'corsFilter'  => [
                'class' => \yii\filters\Cors::class,
                'cors'  => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Headers' => [
                        'Authorization',
                        'Content-Type',
                    ],
                ]
            ]
        ]);
    }
}