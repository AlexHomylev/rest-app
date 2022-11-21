<?php

namespace common\validators;

use yii\validators\RegularExpressionValidator;

class UidValidator extends RegularExpressionValidator
{
    public $pattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i';
}