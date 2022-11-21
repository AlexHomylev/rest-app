<?php

namespace common\components;

use Yii;
use yii\base\Component;
use Aws\S3\S3Client as AwsS3Client;
use Aws\S3\Exception\S3Exception;
use yii\web\UploadedFile;

/**
 * Компонент для работы с S3Client.
 * Class S3Client
 * @package common\components
 */
class S3Client extends Component
{
    /** @var string Ключ доступа Minio */
    public $key;

    /** @var string Секретный ключ Minio */
    public $secret;

    /** @var string Имя хранилища */
    public $bucket;

    /** @var string Путь к сервису */
    public $endpoint;

    /** @var bool Используем ли endpoint */
    public $use_path_style_endpoint = true;

    /** @var string Версия */
    public $version = 'latest';

    /** @var string Регион */
    public $region = 'us-east-1';

    /** @var array S3 Клиент */
    private $s3Client;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function init()
    {
        parent::init();

        $this->s3Client = new AwsS3Client([
            'version' => $this->version,
            'region' => $this->region,
            'endpoint' => $this->endpoint,
            'use_path_style_endpoint' => $this->use_path_style_endpoint,
            'credentials' => [
                'key' => $this->key,
                'secret' => $this->secret,
            ],
        ]);

        $this->createBucket($this->bucket);
    }

    /**
     * В случае если хранилище не создано, создаём. В противном случае ничего не делаем.
     * @param string $bucket
     */
    public function createBucket(string $bucket)
    {
        if (!$this->s3Client->doesBucketExist($bucket)) {
            $this->s3Client->createBucket([
                'Bucket' => $bucket,
            ]);
        }
    }

    /**
     * Загрузка файла в хранилище.
     * @param $name
     * @param $file
     * @return bool
     */
    public function store(string $name, UploadedFile $file)
    {
        try {
            return $this->s3Client->putObject([
                'SourceFile' => $file->tempName,
                'Bucket' => $this->bucket,
                'Key' => $name,
                'ContentType' => $file->type,
            ]);
        } catch (S3Exception $e) {
            throw new \Exception($e);
        }
    }

    /**
     * Проверяем есть ли файл с указанным именем в хранилище.
     * @param string $name
     * @return bool
     */
    public function fileExist(string $name): bool
    {
        $fileList = $this->s3Client->listObjectsV2([
            'Bucket' => $this->bucket,
        ]);
        if ($fileList['Contents']) {
            foreach ($fileList['Contents'] as $file) {
                if ($file['Key'] === $name) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Удаляет файл с указанным именем.
     * @param $name
     * @return bool
     * @throws \Exception
     */
    public function delete(string $name)
    {
        try {
            return $this->s3Client->deleteObject([
                'Bucket' => $this->bucket,
                'Key' => $name,
            ]);
        } catch (S3Exception $e) {
            throw new \Exception($e);
        }
    }
}
