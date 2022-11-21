<?php

namespace tests\codeception\components;

use yii\base\Action;

/**
 * MigrateController
 */
class MigrateController extends \yii\console\controllers\MigrateController
{
    /**
     * @return bool Есть ли есть новые миграции.
     */
    public function hasNewMigrations()
    {
        // Минус подхода в том, что Yii Migration Tool надпись выводится в консоль, ну и черт с ней.
        $this->beforeAction(new Action('hasNew', null));
        return (bool)$this->getNewMigrations();
    }
}
