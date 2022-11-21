<?php

namespace tests\codeception\components\Connector;

use Yii;

/**
 * Коннектор для Yii2 модуля.
 */
class Yii2 extends \Codeception\Lib\Connector\Yii2
{
    /**
     * @inheritdoc
     */
    public $configFile;

    /**
     * @inheritdoc
     */
    private $app;

    /**
     * @inheritdoc
     */
    public static $db; // remember the db instance

    /**
     * @inheritdoc
     */
    public function getApplication()
    {
        if (!isset($this->app)) {
            $this->startApp();
        }
        return $this->app;
    }

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    public function startApp()
    {
        $appClass = \yii\web\Application::class;
        if (Yii::$app instanceof \yii\console\Application) {
            $appClass = \yii\console\Application::class;
        }

        $config = require $this->configFile;
        if (!isset($config['class'])) {
            $config['class'] = $appClass;
        }

        $this->app = Yii::createObject($config);
        $this->persistDb();
        $this->mockMailer($config);
    }

    /**
     * @inheritdoc
     */
    protected function persistDb()
    {
        // always use the same DB connection
        if (static::$db) {
            $this->app->set('db', static::$db);
        } elseif ($this->app->has('db')) {
            static::$db = $this->app->get('db');
        }
    }

    /**
     * Переопределен чтобы не заменял наш mailer.
     */
    protected function mockMailer($config)
    {

    }
}
