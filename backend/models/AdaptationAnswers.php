<?php

namespace backend\models;

use backend\models\Adaptation;

class AdaptationAnswers extends \common\models\AdaptationAnswers
{
    /**
     * @return array|false
     */
    public function fields()
    {
        return [
            'uid',
            'adaptation_uid',
            'username',
            'title',
            'answers',
            'is_processed',
            'device_id',
            'files_status',
            'created_at',
            'updated_at',
            'answer_at',
            'open_at',
        ];
    }
}
