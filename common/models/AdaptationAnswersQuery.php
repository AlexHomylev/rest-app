<?php

namespace common\models;

use yii\db\ActiveQuery;

class AdaptationAnswersQuery extends ActiveQuery
{
    public function byUid($id){
        return $this->where(['uid' => $id]);
    }

    /**
     * Заполнен тест или нет
     * @param int $param
     * @return AdaptationAnswersQuery
     */
    public function withIsFilled(int $param)
    {
        if ($param) {
            return $this->andWhere('answers_jsonb NOTNULL');
        }
        return $this->andWhere(['answers_jsonb' => null]);
    }

    /**
     * Обработан тест или нет
     * @param int $param
     * @return AdaptationAnswersQuery
     */
    public function withIsProcessed(int $param)
    {
        return $this->andWhere(['is_processed' => $param]);
    }

    /**
     * Получаем опросы, которые существуют уже 2 недели.
     * @return array|AdaptationAnswersQuery|\yii\db\ActiveRecord[]
     */
    public function old()
    {
        $t = date('Y-m-d H:i:s', strtotime('-2 weeks'));
        return $this->andWhere('answer_at <= :t', [':t' => $t]);
    }

    /**
     * Получаем тесты по статусу файла
     * @param $params
     * @return AdaptationAnswersQuery
     */
    public function withIsFileStatus($params)
    {
        return $this->andWhere(['files_status' => $params]);
    }
}