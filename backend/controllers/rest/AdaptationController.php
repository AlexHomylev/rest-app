<?php

namespace backend\controllers\rest;

use backend\models\Adaptation;
use common\validators\UidValidator;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\UnprocessableEntityHttpException;

class AdaptationController extends RestController
{
    public $allowedActions = ['index', 'view', 'update', 'create', 'delete'];

    public $modelClass = Adaptation::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        unset($actions['view']);

        return $actions;
    }

    /**
     * Подготовка провайдера данных.
     *
     * @return ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public function prepareDataProvider()
    {
        $modelClass = $this->modelClass;

        $params = Yii::$app->getRequest()->getQueryParams();
        $query = $this->prepareQuery($modelClass, $params);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => Yii::createObject([
                'class' => '\yii\data\Pagination',
            ])
        ]);
    }

    /**
     * Подготовка запроса.
     *
     * @param string|Adaptation $modelClass Класс модели
     * @param array          $params     Параметры поиска
     * @return \yii\db\ActiveQuery
     */
    public function prepareQuery($modelClass, $params)
    {
        $query = $modelClass::find();

        if (isset($params['q'])) {
            $query->andWhere(['ilike', 'title', "%{$params['q']}%", false]);
        }

        return $query;
    }

    public function actionView($id)
    {
        $adaptation = null;

        if ($this->checkUid($id)) {
            $adaptation = Adaptation::find()->where(['uid' => $id])->one();
            if (!$adaptation) {
                throw new NotFoundHttpException('Adaptation is not exist');
            }
        } else {
            throw new UnprocessableEntityHttpException('UID is invalid');
        }

        return $adaptation;
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