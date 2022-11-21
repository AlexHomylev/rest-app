<?php

namespace common\components;

use common\validators\UidValidator;

trait FindByUidOrDeviceIdTrait
{
    public static function findByUidOrDeviceId($deviceIdOrGuid)
    {
        $validator = new UidValidator();
        $isGuid = $validator->validate($deviceIdOrGuid);

        if ($isGuid) {
            return parent::findOne(['uid' => $deviceIdOrGuid]);
        } else {
            if (is_numeric($deviceIdOrGuid)) {
                return parent::findOne(['device_id' => $deviceIdOrGuid]);
            }
            return null;
        }
    }

    public static function findOne($condition)
    {
        if (is_array($condition)) {
            return parent::findOne($condition);
        }

        return static::findByUidOrDeviceId($condition);
    }
}