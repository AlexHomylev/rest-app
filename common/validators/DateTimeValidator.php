<?php

namespace common\validators;


class DateTimeValidator extends \yii\validators\DateValidator
{
    public $format = 'yyyy-MM-dd HH:mm:ss';
}