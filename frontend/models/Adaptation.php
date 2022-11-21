<?php

namespace frontend\models;

/**
 * Модель для отображения теста пользователю без лишней инфы.
 * Class Adaptation
 * @package frontend\models
 */
class Adaptation extends \common\models\Adaptation
{
    /**
     * Выводим только необходимые поля.
     * @return array|false
     */
    public function fields()
    {
        return [
            'title',
            'questions',
            'style',
            'survey_type',
            'explanation',
            'is_shuffle',
        ];
    }
}
