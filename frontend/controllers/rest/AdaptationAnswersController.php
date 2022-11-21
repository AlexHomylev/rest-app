<?php

namespace frontend\controllers\rest;

use common\helpers\ArrayHelper;
use frontend\forms\AdaptationForm;
use frontend\models\AdaptationAnswers;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UnprocessableEntityHttpException;
use yii\web\UploadedFile;

/**
 * Контроллер для просмотра тестов и отправки ответов на них.
 * Class AdaptationAnswersController
 * @package frontend\controllers\rest
 */
class AdaptationAnswersController extends \yii\rest\Controller
{
    public $modelClass = AdaptationAnswers::class;

    public function actions()
    {
        return [
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ]
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'corsFilter' => [
                    'class' => \yii\filters\Cors::class,
                    'cors' => [
                        'Origin' => ['*'],
                        'Access-Control-Request-Method' => ['GET', 'POST'],
                        'Access-Control-Request-Headers' => [
                            'Content-Type',
                        ],
                    ]
                ]
            ]
        );
    }

    /**
     * Вывод теста.
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws UnprocessableEntityHttpException
     */
    public function actionView($id)
    {
        $answer = $this->findAnswerByDeviceIdOrUID($id);
        $this->checkAnswerNotFilled($answer);
        return $answer;
    }

    /**
     * Отправка ответов на тест.
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     * @throws UnprocessableEntityHttpException
     */
    public function actionCreate($id)
    {
        $answers = $this->findAnswerByDeviceIdOrUID($id);
        $this->checkAnswerNotFilled($answers);

        $requestData = \Yii::$app->request->post();
        $form = new AdaptationForm($requestData);

        $form->files = UploadedFile::getInstancesByName('files');
        if (!$form->validate()) {
            return $form;
        }

        if ($answers->load($requestData, '')) {
            $answers->answers = $form->answers;

            if ($form->files) {
                if (!$answers->saveDocs($form->files)) {
                    throw new ServerErrorHttpException('Не могу сохранить файл.');
                }
                $answers->files_status = AdaptationAnswers::FILE_STATUS_ATTACHED;
            } else {
                $answers->files_status = AdaptationAnswers::FILE_STATUS_NONE;
            }

            if ($answers->save() === false && !$answers->hasErrors()) {
                throw new ServerErrorHttpException('Не могу сохранить ответы на тест.');
            }
        }

        return $answers;
    }

    /**
     * Проверяем существование запрашиваемого назначения на тест.
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    private function findAnswerByDeviceIdOrUID($id)
    {
        $answer = $this->modelClass::findOne($id);
        if (!$answer) {
            throw new NotFoundHttpException('Назначения для теста с таким UID или DeviceID не найдена.');
        }
        return $answer;
    }

    /**
     * Проверяем выполнен ли тест.
     * @param $answer
     * @throws UnprocessableEntityHttpException
     */
    private function checkAnswerNotFilled($answer)
    {
        if ($answer->answers_jsonb != null) {
            throw new UnprocessableEntityHttpException('Тест уже выполнен.');
        }
    }
}

