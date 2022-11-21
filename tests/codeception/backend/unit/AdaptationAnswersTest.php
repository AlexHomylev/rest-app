<?php

namespace codeception\backend\unit;

use backend\controllers\rest\AdaptationAnswersController;
use backend\models\AdaptationAnswers;
use tests\codeception\backend\unit\TestCase;
use tests\codeception\common\fixtures\AdaptationAnswersFixture;
use tests\codeception\common\fixtures\AdaptationFixture;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UnprocessableEntityHttpException;

class AdaptationAnswersTest extends TestCase
{
    protected $tester;

    public function fixtures()
    {
        return [
            'adaptation' => AdaptationFixture::class,
            'adaptation_answers' => AdaptationAnswersFixture::class,
        ];
    }

    public function testUid()
    {
        $model = new AdaptationAnswers();

        $model->uid = '649a9c4c-1b4b-46c9-932d-8a50f3ee23ff';
        $this->assertTrue($model->validate('uid'));

        $model->uid = null;
        $this->assertFalse($model->validate('uid'));
    }

    public function testAdaptationUid()
    {
        $model = new AdaptationAnswers();

        $model->adaptation_uid = 'ac0da11b-a5df-40cb-96bf-23716e066dd9';
        $this->assertTrue($model->validate('adaptation_uid'));

        $model->adaptation_uid = '649a9c4c-1b4b-46c9-932d-8a50f3ee23gg';
        $this->assertFalse($model->validate('adaptation_uid'));

        $model->adaptation_uid = null;
        $this->assertFalse($model->validate('adaptation_uid'));
    }

    public function testUserName()
    {
        $model = new AdaptationAnswers();

        $model->username = 'Gabe Logan';
        $this->assertTrue($model->validate('username'));

        $model->username = 232352352352;
        $this->assertFalse($model->validate('username'));
    }

    public function testQuestions()
    {
        $model = new AdaptationAnswers();

        $model->answers = [
            [
                'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23da',
                'type' => 1,
                'answer' => 7,
                'comment' => 'Комментарий'
            ],
            [
                'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23db',
                'type' => 2,
                'answer' => 26
            ],
            [
                'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23dc',
                'type' => 3,
                'answer' => 'Ответ на вопрос текстом'
            ],
            [
                'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23dd',
                'type' => 4,
                'answer' => [
                    '3',
                    '4'
                ],
            ],
            [
                'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23de',
                'type' => 5,
                'answer' => [
                    '4'
                ],
                'comment' => 'Комментарий'
            ]
        ];
        $this->assertTrue($model->validate('answers'));
    }

    public function testDeleteSuccess()
    {
        $controller = new AdaptationAnswersController('adaptationAnswers', Yii::$app);

        $controller->actionDelete('b42afd0a-01ef-4787-848d-160894d8e7cb');
        $adaptation = AdaptationAnswers::find()->where(['uid' => 'b42afd0a-01ef-4787-848d-160894d8e7cb'])->one();
        $this->assertNull($adaptation);
    }

    public function testDeleteFilled()
    {
        $controller = new AdaptationAnswersController('adaptationAnswers', Yii::$app);

        $this->expectException(UnprocessableEntityHttpException::class);
        $controller->actionDelete('a78fdcfa-bf49-4412-9db2-8168b6b283e8');
    }

    public function testDeleteIncorrectUid()
    {
        $controller = new AdaptationAnswersController('adaptationAnswers', Yii::$app);

        $this->expectException(UnprocessableEntityHttpException::class);
        $controller->actionDelete('123123-adadada');
    }

    public function testDeleteUidNotFound()
    {
        $controller = new AdaptationAnswersController('adaptationAnswers', Yii::$app);

        $this->expectException(NotFoundHttpException::class);
        $controller->actionDelete('a28fdcfa-af57-2345-9db2-8168b6b283e9');
    }
}
