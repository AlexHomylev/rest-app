<?php

namespace common\models;

use yii\base\Model;

class Question extends Model
{
    // Тип вопроса, к которому прикрепляются файлы
    const WITH_FILES_TYPE = 6;

    /**
     * Идентификатор
     * @var integer
     */
    public $id;

    /**
     * Тип вопроса
     * @var integer
     */
    public $type;

    /**
     * Тест вопроса
     * @var string
     */
    public $question;

    /**
     * Пояснение к вопросу
     * @var string
     */
    public $explanation;

    /**
     * Разрешено ли оставлять комментарии
     * @var boolean
     */
    public $comment;

    /**
     * Блок с ответами на вопрос, он нужен только для типов вопроса 4 и 5
     * @var array
     */
    public $answers;

    /**
     * Кол-во полей для загрузки файлов; указывается, если для ответа на вопрос необходимо загрузить файлы во все имеющиеся поля; не указывается, если есть min_count и max_count
     * @var integer
     */
    public $count;

    /**
     * Подсказки
     * @var string
     */
    public $hint;

    /**
     * Минимальное кол-во файлов, которое необходимо для того, чтобы ответ засчитался; не указывается, если есть count; указывается только в паре с max_count
     * @var integer
     */
    public $min_count;

    /**
     * Максимальное кол-во файлов, которое можно загрузить; по сути работает аналогично count; указывается только в паре с min_count
     * @var integer
     */
    public $max_count;

    /**
     * Регулярное выражение для валидации пользовательского ввода
     * @var string
     */
    public $match;

    /**
     * Для placeholders
     * @var string
     */
    public $placeholder;

    /**
     * Необьязательный вопрос
     * @var boolean
     */
    public $is_not_required;

    /**
     * Скрывать ли вопрос
     * @var boolean
     */
    public $is_hidden;

    /**
     * Представление вопроса
     * @var string
     */
    public $view;

    public function fields()
    {
        $fields = [
            'id',
            'type',
            'question',
            'explanation',
            'comment',
            'answers',
            'count',
            'max_count',
            'min_count',
            'hint',
            'match',
            'placeholder',
            'is_not_required',
            'is_hidden',
            'view'
        ];

        return $fields;
    }

    public function rules()
    {
        return [
            [['id', 'type', 'question', 'is_not_required'], 'required'],
            ['type', 'integer'],
            ['is_hidden', 'default', 'value' => false],
            [['is_not_required', 'is_hidden'], 'boolean'],
            ['view', 'string']
        ];
    }

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * Проверяем что тип вопроса предполагает загрузку файлов.
     * @return bool
     */
    public function isWithFile(): bool
    {
        return $this->type === self::WITH_FILES_TYPE;
    }
}