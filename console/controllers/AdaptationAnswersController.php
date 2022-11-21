<?php

namespace console\controllers;

use common\models\AdaptationAnswers;
use yii\console\Controller;
use yii\helpers\Console;

class AdaptationAnswersController extends Controller
{
    /**
     * Удаляем файлы пользователей после 2 недель с момента обработки is processed = true и меняем files_status на deleted.
     */
    public function actionDeleteOldAdaptationFiles()
    {
        $adaptationAnswers = new AdaptationAnswers;
        $deletedAdaptationCount = 0;
        foreach ($adaptationAnswers::find()->old()->withIsProcessed(true)->withIsFileStatus(AdaptationAnswers::FILE_STATUS_ATTACHED)->each() as $adaptationAnswer) {
            $deletedAdaptationCount++;
            $adaptationAnswer->deleteFiles();
            if (!$adaptationAnswer->save()) {
                $this->stdout("Failed to update record. UID: {$adaptationAnswer->uid} \n", Console::BOLD);
            }
        }
        $this->stdout("Delete, complete without errors. Congrats! \nTotal count: $deletedAdaptationCount \n", Console::FG_GREEN);
        return 0;
    }
}