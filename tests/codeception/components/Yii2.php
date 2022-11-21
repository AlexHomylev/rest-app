<?php

namespace tests\codeception\components;

use Codeception\TestInterface;
use Codeception\Configuration;
use tests\codeception\components\Connector\Yii2 as Yii2Connector;
use yii\helpers\Console;

/**
 * Модуль Yii2 для Codeception.
 */
class Yii2 extends \Codeception\Module\Yii2
{
    /**
     * @inheritdoc
     */
    protected $config = [
        'cleanup'     => true,
        'transaction' => null,
        'entryScript' => '',
        'entryUrl'    => 'http://localhost/index-test.php',
    ];

    /**
     * Обязательное поле конфигурации модуля.
     *
     * @var array
     */
    protected $requiredFields = ['configFile'];

    /**
     * Переменная транзакций приложения.
     */
    protected $transaction;

    /**
     * @inheritdoc
     */
    public $app;

    /**
     * @inheritdoc
     */
    public $loadedFixtures = [];

    public function _before(TestInterface $test)
    {
        $entryUrl = $this->config['entryUrl'];
        $entryFile = $this->config['entryScript'] ?: basename($entryUrl);
        $entryScript = $this->config['entryScript'] ?: parse_url($entryUrl, PHP_URL_PATH);

        $this->client = new Yii2Connector();
        $this->client->defaultServerVars = [
            'SCRIPT_FILENAME' => $entryFile,
            'SCRIPT_NAME'     => $entryScript,
            'SERVER_NAME'     => parse_url($entryUrl, PHP_URL_HOST),
            'SERVER_PORT'     => parse_url($entryUrl, PHP_URL_PORT) ?: '80',
        ];
        $this->client->defaultServerVars['HTTPS'] = parse_url($entryUrl, PHP_URL_SCHEME) === 'https';
        $this->client->restoreServerVars();
        $this->client->configFile = Configuration::projectDir() . $this->config['configFile'];
        $this->app = $this->client->getApplication();

        // Применяем миграции
        $migrateController = new MigrateController('migrate', \Yii::$app);
        $migrateController->migrationPath = '@console/migrations';
        if ($isDumpRequired = $migrateController->hasNewMigrations()) {
            Console::stdout("Migrate up .....\n");
            $migrateController->runAction('up', ['interactive' => 0]);
        }

        // load fixtures before db transaction
        if ($test instanceof \Codeception\Test\Cest) {
            $this->loadFixtures($test->getTestClass());
        } else {
            $this->loadFixtures($test);
        }

        if ($this->config['transaction']
            && $this->app->has('db')
            && $this->app->db instanceof \yii\db\Connection
        ) {
            $this->transaction = $this->app->db->beginTransaction();
            $this->debugSection('Database', 'Transaction started');
        }
    }

    /**
     * @inheritdoc
     */
    private function loadFixtures($test)
    {
        if (empty($this->loadedFixtures)
            && method_exists($test, self::TEST_FIXTURES_METHOD)
        ) {
            $this->haveFixtures(call_user_func([$test, self::TEST_FIXTURES_METHOD]));
        }
    }
}
