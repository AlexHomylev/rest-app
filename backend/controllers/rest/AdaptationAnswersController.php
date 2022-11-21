<?php

namespace backend\controllers\rest;

use backend\models\AdaptationAnswers;
use common\models\AdaptationAnswersQuery;
use common\validators\UidValidator;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UnprocessableEntityHttpException;

class AdaptationAnswersController extends RestController
{
    public $allowedActions = ['index', 'view', 'update', 'create', 'delete'];

    public $modelClass = AdaptationAnswers::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        unset($actions['view'], $actions['delete']);

        return $actions;
    }

    public function actionView($id)
    {
        $adaptationAnswers = null;

        if ($this->checkUid($id)) {
            $adaptationAnswers = AdaptationAnswers::find()->where(['uid' => $id])->one();
            if (!$adaptationAnswers) {
                throw new NotFoundHttpException('Adaptation not exist.');
            }
        } else {
            throw new UnprocessableEntityHttpException('Invalid UID.', '422');
        }

        return $adaptationAnswers;
    }

    /**
     * Подготовка провайдера данных.
     *
     * @return ActiveDataProvider
     */
    public function prepareDataProvider()
    {
        $model = new $this->modelClass;

        $params = Yii::$app->getRequest()->getQueryParams();
        $query = $this->prepareQuery($model, $params);

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

    /**
     * Подготовка запроса.
     *
     * @param array $params Параметры поиска
     * @return AdaptationAnswersQuery
     */
    private function prepareQuery($model, $params)
    {
        /** @var AdaptationAnswersQuery $query */
        $query = $model::find();

        if (isset($params['is_filled'])) {
            $query->withIsFilled($params['is_filled']);
        }

        if (isset($params['is_processed'])) {
            $query->withIsProcessed($params['is_processed']);
        }

        return $query;
    }

    /**
     * Удаление назначения. Можно удалять только уже пройденные назначения.
     * @param $id
     * @return void
     * @throws ServerErrorHttpException
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id)
    {
        if (!$this->checkUid($id)) {
            throw new UnprocessableEntityHttpException('Invalid UID.', '422');
        }

        $adaptationAnswers = AdaptationAnswers::find()->byUid($id)->one();
        if (!$adaptationAnswers) {
            throw new NotFoundHttpException('Adaptation not exist.');
        }

        if ($adaptationAnswers->answers) {
            throw new UnprocessableEntityHttpException('Unable to delete a completed Adaptation.', '422');
        }

        if ($adaptationAnswers->delete() === false) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }

        Yii::$app->getResponse()->setStatusCode(204);
    }

    /**
     * Проверим что переданный идентификатор UID, соответствует требованиям.
     * @param string $uid
     * @return bool
     */
    private function checkUid(string $uid): bool
    {
        $uidValidator = new UidValidator();
        return $uidValidator->validate($uid);
    }
}