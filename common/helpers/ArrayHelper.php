<?php

namespace common\helpers;

class ArrayHelper extends \yii\helpers\ArrayHelper
{
    /**
     * Превращает строку с числами разделенными запятой в массив.
     * @param string $string
     * @return array
     */
    public static function fromString($string)
    {
        return array_unique(array_map(
            'intval',
            explode(',', $string)
        ));
    }
}
