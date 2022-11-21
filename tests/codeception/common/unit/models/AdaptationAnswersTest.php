<?php

namespace tests\codeception\common\unit\models;

use backend\models\AdaptationAnswers;
use tests\codeception\backend\unit\TestCase;

class AdaptationAnswersTest extends TestCase
{
    public function testOpenAt()
    {
        $model = new AdaptationAnswers();

        $model->open_at = '2021-02-20 15:50:00';
        $this->assertTrue($model->validate('open_at'));

        $model->open_at = 1234567890;
        $this->assertFalse($model->validate('open_at'));
    }
}
