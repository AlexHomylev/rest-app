<?php

namespace frontend\controllers\rest;

use common\helpers\ArrayHelper;
use common\validators\UidValidator;
use frontend\components\uuid\UUID;
use frontend\forms\AdaptationForm;
use frontend\models\Adaptation;
use frontend\models\AdaptationAnswers;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

/**
 * Контроллер для просмотра тестов и отправки ответов на них.
 * Class AdaptationAnswersController
 * @package frontend\controllers\rest
 */
class AdaptationController extends \yii\rest\Controller
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
     * Вывод формы.
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->findAdaptation($id);
    }

    /**
     * Отправка анонимных ответов на форму.
     * @param $id
     * @return mixed
     * @throws ServerErrorHttpException
     * @throws \yii\base\Exception
     */
    public function actionCreateAnswer($id)
    {
        $adaptationUid = $id;
        $this->findAdaptation($adaptationUid);
        $answerUid = UUID::v4();
        $answer = new AdaptationAnswers();
        $answer->uid = $answerUid;
        $answer->adaptation_uid = $adaptationUid;

        $requestData = \Yii::$app->request->post();
        $form = new AdaptationForm($requestData);

        $form->files = UploadedFile::getInstancesByName('files');
        if (!$form->validate()) {
            return $form;
        }

        if ($answer->load($requestData, '')) {
            $answer->answers = $form->answers;

            if ($form->files) {
                if (!$answer->saveDocs($form->files)) {
                    throw new ServerErrorHttpException('Не могу сохранить файл.');
                }
                $answer->files_status = AdaptationAnswers::FILE_STATUS_ATTACHED;
            } else {
                $answer->files_status = AdaptationAnswers::FILE_STATUS_NONE;
            }

            if ($answer->save() === false && !$answer->hasErrors()) {
                throw new ServerErrorHttpException('Не могу сохранить ответы на тест.');
            }
        }

        return $answer;
    }

    /**
     * Проверяем существование формы адаптации.
     * @param $uid
     * @return mixed
     * @throws NotFoundHttpException
     */
    private function findAdaptation($uid)
    {
        $validator = new UidValidator();
        $isGuid = $validator->validate($uid);
        if ($isGuid) {
            $adaptation = Adaptation::find()->where(['uid' => $uid])->one();
            if (!$adaptation) {
                throw new NotFoundHttpException('Форма с таким UID не найдена.');
            }
            return $adaptation;
        }
        throw new NotFoundHttpException('Получен некоректный UID.');
    }
}

