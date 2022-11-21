<?php

namespace common\components;

class Connection extends \yii\db\Connection
{
    use SetAppNameTrait;

    public function init()
    {
        $this->configureApplicationName();
        parent::init();
    }
}
