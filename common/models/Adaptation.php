<?php

namespace common\models;

use common\behaviors\TimestampBehavior;
use common\validators\DateTimeValidator;
use common\validators\UidValidator;
use yii\db\ActiveRecord;

/**
 * Class Adaptation
 * @package common\models
 * @property string $uid [uuid]
 * @property string $name [varchar(255)]
 * @property string $form_jsonb [jsonb]
 * @property string $style
 * @property int $created_at [timestamp(0)]
 * @property int $updated_at [timestamp(0)]
 * @property string $explanation
 */
class Adaptation extends ActiveRecord
{
    const NORMAL_STYLE = 'normal';
    const DRIVER_STYLE = 'driver';
    const FAMILY_STYLE = 'family';

    public static function tableName()
    {
        return 'adaptation';
    }   

    /**
     * @return array|false
     */
    public function fields()
    {
        return [
            'uid',
            'title',
            'questions',
            'style',
            'survey_type',
            'created_at',
            'updated_at',
            'explanation',
            'is_shuffle'
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'UID',
            'questions' => 'Вопросы',
            'title' => 'Название',
            'style' => 'Стиль',
            'survey_type' => 'Тип опроса'
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    public function rules()
    {
        return [
            [['uid', 'questions'], 'required'],

            ['uid', UidValidator::class],
            ['uid', 'unique'],

            ['title', 'string'],

            ['style', 'string'],
            ['style', 'default', 'value' => static::NORMAL_STYLE],
            ['style', 'in', 'range' => [static::NORMAL_STYLE, static::DRIVER_STYLE, static::FAMILY_STYLE]],

            [['questions'], 'validateQuestionsInstance', 'skipOnEmpty' => true],
            [['questions'], 'validateQuestions', 'skipOnEmpty' => true],

            ['survey_type', 'integer'],

            [['created_at', 'updated_at'], DateTimeValidator::class],

            [['explanation'], 'string', 'skipOnEmpty' => true],

            ['is_shuffle', 'boolean'],
            ['is_shuffle', 'default', 'value' => false],
        ];
    }

    public function getQuestions()
    {
        $result = [];
        $data = $this->form_jsonb ?: [];
        foreach ($data as $entry) {
            $result[] = new Question($entry);
        }
        return $result;
    }

    public function setQuestions(array $questions)
    {
        $this->form_jsonb = $questions;
    }

    /**
     * Есть ли в Адаптации вопрос содержащий файлы.
     * @return bool
     */
    public function isWithFiles()
    {
        foreach ($this->getQuestions() as $question) {
            if ($question->isWithFile()) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $attribute
     * @param $params
     * @param $validator
     */
    public function validateQuestions ($attribute, $params, $validator) {
        /** @var Question $question */
        foreach ($this->$attribute as $question) {
            if (!$question->validate()) {
                foreach ($question->getErrors() as $attr => $error) {
                    foreach ($error as $err) {
                        $this->addError("question.$question->id.$attr", $err);
                    }
                }
            }
        }
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validateQuestionsInstance($attribute, $params, $validator)
    {
        foreach ($this->$attribute as $question) {
            if (!($question instanceof Question)) {
                $this->addError($attribute, 'Attribute questions must be Question[] array.');
                return;
            }
        }
    }
}
