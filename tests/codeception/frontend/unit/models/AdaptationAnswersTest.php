<?php

namespace codeception\frontend\unit\models;

use common\models\AdaptationAnswers;
use tests\codeception\frontend\unit\TestCase;

class AdaptationAnswersTest extends TestCase
{
    public function testAnswerAtUpdate()
    {
        $model = new AdaptationAnswers();
        $model->setOldAttribute('answers_jsonb', null);
        $model->answers_jsonb = [
            [
                'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23da',
                'type' => 1,
                'answer'=> 7,
                'comment' => 'Комментарий'
            ]
        ];
        $model->validate(['answers_jsonb', 'answers']);
        $oldData = $model->answer_at;
        $this->assertEquals(date('c'), $oldData);

        $model->setOldAttribute('answers_jsonb', $model->answers_jsonb);
        $model->is_processed = true;
        $this->assertEquals($oldData, $model->answer_at);
    }

    public function testAnswerAtCreate()
    {
         $model = new AdaptationAnswers();
         $model->setAttributes([
             'uid' => '33e2b734-6e27-49da-868c-a01455a86e07',
             'adaptation_uid' => 'ac0da11b-a5df-40cb-96bf-23716e066dd9',
             'username' => 'Gabe Logan',
             'answers' => null,
             'device_id' => 14
         ]);
         $model->validate();

         $this->assertEquals(null, $model->answer_at);
    }
}
