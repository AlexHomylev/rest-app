<?php

namespace codeception\console\unit\models;

use common\models\AdaptationAnswers;
use tests\codeception\common\fixtures\AdaptationAnswersFixture;
use tests\codeception\common\fixtures\AdaptationFixture;
use tests\codeception\console\unit\TestCase;
use yii\helpers\FileHelper;

class AdaptationAnswersTest extends TestCase
{
    public function fixtures()
    {
        return [
            'adaptation' => AdaptationFixture::class,
            'adaptation_answers' => AdaptationAnswersFixture::class,
        ];
    }

    public function testDeleteDirectory()
    {
        $model = new AdaptationAnswers;
        $model->uid = '1df00090-29ec-4e1c-a259-a1fa8368c5f9';
        $path = $model->getDocsAdaptationPath();

        FileHelper::createDirectory($path);
        $this->assertEquals(true, file_exists($path));

        $model->deleteFiles();
        $this->assertEquals(false, file_exists($path));
        $this->assertEquals($model->files_status, AdaptationAnswers::FILE_STATUS_DELETED);
    }

    public function testGetOldAdaptations()
    {
        $model = new AdaptationAnswers;
        $result = $model::find()->where(['uid' => '1df00090-29ec-4e1c-a259-a1fa8368c5f9'])->all();
        $this->assertEquals($result, $model::find()->old()->withIsProcessed(true)->withIsFileStatus([AdaptationAnswers::FILE_STATUS_UNKNOWN, AdaptationAnswers::FILE_STATUS_ATTACHED])->all());
    }
}