<?php

namespace common\models;

use common\behaviors\TimestampBehavior;
use common\components\FindByUidOrDeviceIdTrait;
use yii\helpers\FileHelper;
use common\validators\DateTimeValidator;
use common\validators\UidValidator;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 *
 * @property string $uid [uuid] Идентификатор назначения.
 * @property string $adaptation_uid [uuid] Идентификатор опроса.
 * @property string|null $title [string(120)] Заголовок для назначения.
 * @property string $username [varchar(255)] ФИО кому назначен опрос.
 * @property bool $is_processed [boolean] Признак того что, 1С обработала назначение.
 * @property int $created_at [timestamp(0)] Время создания назначение
 * @property int $updated_at [timestamp(0)] Время обновления назначение.
 * @property int $answer_at [timestamp(0)] Время когда пользователь отправил ответы на опрос.
 * @property string $answers_jsonb [jsonb] Массив ответов на опрос.
 * @property string $files_status [varchar(20)] Признак того что, опрос содержит вопрос предполагающий загрузку файлов в качестве ответа.
 * @property int $open_at [timestamp(0)] Время первого открытия ссылки
 *
 * @property \common\models\Answer[] $answers
 * @property \common\models\Adaptation[] $adaptation
 */
class AdaptationAnswers extends ActiveRecord
{
    use FindByUidOrDeviceIdTrait;

    // Неизвестный статус Адаптации
    const FILE_STATUS_UNKNOWN = 'unknown';
    // Файлы не прикреплены
    const FILE_STATUS_NONE = 'none';
    // Файлы прикреплены
    const FILE_STATUS_ATTACHED = 'attached';
    // Файлы удалены
    const FILE_STATUS_DELETED = 'deleted';

    public static function tableName()
    {
        return 'adaptation_answers';
    }

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
            'оpen_at',
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'UID',
            'adaptation_uid' => 'UID теста',
            'username' => 'Имя пользователя',
            'title' => 'Заголовок',
            'answers' => 'Ответы',
            'files_status' => 'Статус файлов'
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
            [['uid', 'adaptation_uid'], 'required'],
            ['uid', 'unique'],
            ['uid', UidValidator::class],
            ['adaptation_uid', UidValidator::class],

            ['adaptation_uid', function ($attribute) {
                $adaptation = Adaptation::find()->where(['uid' => $this->$attribute])->exists();
                if (!$adaptation) {
                    $this->addError($attribute, 'Не найдено теста по указанному UID');
                }
            }],

            ['answers', function ($attribute) {
                foreach ($this->$attribute as $answer) {
                    if (!$answer->validate()) {
                        foreach ($answer->getErrors() as $attr => $error) {
                            foreach ($error as $err) {
                                $this->addError("answer.$answer->id.$attr", $err);
                            }
                        }
                    }
                }
            }],

            ['answers', function () {
                if ($this->isAttributeChanged('answers_jsonb') && is_null($this->getOldAttribute('answers_jsonb'))) {
                    $this->answer_at = date('c');
                }
            }],

            ['username', 'string'],
            ['title', 'string'],
            ['is_processed', 'boolean'],
            ['device_id', 'integer'],
            ['device_id', 'unique'],

            ['files_status', 'string'],
            ['files_status', 'default', 'value' => static::FILE_STATUS_UNKNOWN],
            ['files_status', 'in', 'range' => [static::FILE_STATUS_UNKNOWN, static::FILE_STATUS_ATTACHED, static::FILE_STATUS_DELETED, static::FILE_STATUS_NONE]],

            [['created_at', 'updated_at', 'open_at'], DateTimeValidator::class],
        ];
    }

    public function getAdaptation()
    {
        return $this->hasOne(Adaptation::class, ['uid' => 'adaptation_uid']);
    }

    public function getAnswers()
    {
        $result = [];
        $data = $this->answers_jsonb ?: [];
        foreach ($data as $entry) {
            $result[] = new Answer($entry);
        }
        return $result;
    }

    /**
     * Прогоняем Answers через отельную модель что бы отсеить лишние данные,
     * и произвести её валидацию.
     * @param $answers
     */
    public function setAnswers($answers)
    {
        if (is_array($answers)) {
            $answersArray = [];
            foreach ($answers as $answer) {
                $answersArray[] = [
                    'id' => $answer['id'] ?? null,
                    'type' => $answer['type'] ?? null,
                    'comment' => $answer['comment'] ?? null,
                    'answer' => $answer['answer'] ?? null,
                ];
            }
            $this->answers_jsonb = $answersArray;
        }
    }

    /**
     * Вернет путь до папки с документами.
     * @return bool|string
     */
    public static function getDocsPath()
    {
        return \Yii::getAlias('@backend/web/files/adaptation');
    }

    /**
     * Вернёт путь до папки с документами, на определённый тест.
     * @return string
     */
    public function getDocsAdaptationPath()
    {
        return static::getDocsPath() . "/" . $this->uid;
    }

    /**
     * Добавляем в ответ на вопрос ссылку на загруженный файл.
     * @param $fileFolder
     * @param $fileName
     */
    public function saveDocFileUrl($fileFolder, $fileName)
    {
        $url = '/files/adaptation' . '/' . $this->uid . '/' . $fileFolder . '/' . $fileName;
        foreach ($this->getAnswers() as $answer) {
            if ($answer->id == $fileFolder) {
                $answer->answer[] = $url;
            }
            $answerArray[] = $answer;
        }
        $this->answers = $answerArray;
    }

    /**
     * Сохранит документы куда надо.
     * @param UploadedFile[] $files
     * @return bool
     * @throws \yii\base\Exception
     */
    public function saveDocs($files)
    {
        FileHelper::createDirectory(static::getDocsAdaptationPath(), 0777);

        foreach ($files as $file) {
            // Парсим переданное имя файла формата <question uid>_<file number>
            $baseNameArray = explode("_", $file->baseName);
            $fileFolder = $baseNameArray[0]; // <question_uid>
            $fileName = "{$baseNameArray[1]}.{$file->getExtension()}"; // <file number>.<ext>

            // Создаём папку для вопроса, чтобы поместить туда загруженные файлы.
            FileHelper::createDirectory(static::getDocsAdaptationPath() . '/' . $fileFolder, 0777);

            // Путь до загружаемого файла.
            $path = static::getDocsAdaptationPath() . '/' . $fileFolder . '/' . $fileName;
            if (!$file->saveAs($path)) {
                return false;
            }

            // Добавляем в ответ, путь до загруженного файла.
            $this->saveDocFileUrl($fileFolder, $fileName);
        }
        return true;
    }

    /**
     * Удаляем папку с загруженными файлами Адаптации.
     * @throws \yii\base\ErrorException
     */
    public function deleteFiles()
    {
        $path = $this->getDocsAdaptationPath();
        FileHelper::removeDirectory($path);
        $this->setFilesStatus(static::FILE_STATUS_DELETED);
    }

    /**
     * Есть ли в Адаптации вопрос содержащий файлы.
     * @return bool
     */
    public function isWithFiles()
    {
        $adaptation = $this->getAdaptation()->one();
        return $adaptation->isWithFiles();
    }

    /**
     * Получаем files_status Опроса проверяя содержиться ли вопросы, предполагающие загрузку файла в качестве ответа.
     * @return string
     */
    public function checkFilesStatus(): string
    {
        if ($this->isWithFiles()) {
            return self::FILE_STATUS_ATTACHED;
        }
        return self::FILE_STATUS_NONE;
    }

    public function setFilesStatus(string $status)
    {
        $this->files_status = $status;
    }

    /**
     * @return AdaptationAnswersQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new AdaptationAnswersQuery(get_called_class());
    }
}
