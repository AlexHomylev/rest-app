<?php

namespace frontend\models;

/**
 * Class AdaptationAnswers
 * @package frontend\models
 */
class AdaptationAnswers extends \common\models\AdaptationAnswers
{
    /**
     * @return array|false
     */
    public function fields()
    {
        return [
            'uid',
            'adaptation',
            'username',
            'title' => function() {
                return $this->getTitle();
            },
            'answers',
            'is_processed',
            'device_id',
            'open_at'
        ];
    }

    /**
     * @return array|Adaptation|\yii\db\ActiveQuery|\yii\db\ActiveRecord|null
     */
    public function getAdaptation()
    {
        return Adaptation::find()->where(['uid' => $this->adaptation_uid])->one();
    }

    /**
     * @return \common\models\Adaptation|string|null
     */
    public function getTitle()
    {
        if ($this->title) {
            return $this->title;
        }
        return $this->adaptation->title;
    }
}