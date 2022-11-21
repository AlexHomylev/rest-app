<?php

namespace console\controllers;

use yii\console\Controller;

/**
 * Контроллер для cron - задач.
 */
class CronController extends Controller
{
    /**
     * Ежедневные операции
     */
    public function actionDaily()
    {
        \Yii::$app->runAction('adaptation-answers/delete-old-adaptation-files');
        \Yii::$app->runAction('anketa/delete-old-files');
    }
}
