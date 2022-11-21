<?php

namespace backend\models;

class Adaptation extends \common\models\Adaptation
{
    public function fields()
    {
        return [
            'uid',
            'title',
            'style',
            'survey_type',
            'questions',
            'created_at',
            'updated_at',
            'explanation',
            'is_shuffle',
        ];
    }
}
