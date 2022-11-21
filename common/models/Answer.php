<?php

namespace common\models;

use yii\base\Model;

class Answer extends Model
{

    public $id;
    public $type;
    public $comment;
    public $answer;

    public function fields()
    {
        return [
            'id' => function () {
                return $this->id;
            },
            'type' => function () {
                return $this->type;
            },
            'comment' => function () {
                return $this->comment;
            },
            'answer' => function () {
                return $this->answer;
            },
        ];
    }

    public function rules()
    {
        return [
            [['id', 'type'], 'required'],
            ['answer', 'required', 'message' => 'Пожалуйста, ответьте на вопрос.'],
            ['type', 'integer'],
            ['comment', 'string']
        ];
    }

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }
}