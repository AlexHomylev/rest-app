<?php

namespace frontend\forms;

use yii\helpers\Json;

class AdaptationForm extends \yii\base\Model
{
    public $answers;

    public $files;
    /** @var string */
    public $open_at;

    public function rules()
    {
        return [
            ['answers', 'required', 'message' => 'Пожалуйста, ответьте на все вопросы.'],
            ['answers', 'filter', 'filter' => function($value) {
                if (is_string($value)) {
                    return Json::decode($value);
                }
                return $value;
            }],
            [
                ['files'],
                'file',
                'extensions' => ['png', 'jpg', 'jpeg', 'pdf'],
                'maxSize' => 1024 * 1024 * 15,
                'maxFiles' => 15
            ],
            [['open_at'], 'safe']
        ];
    }
}
