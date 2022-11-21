<?php

namespace tests\codeception\common\unit\models;

use common\models\Adaptation;
use tests\codeception\common\unit\TestCase;

class AdaptationTest extends TestCase
{
    public function testExplanation()
    {
        $model = new Adaptation();

        $model->explanation = 'Тесовое описание анкеты.';
        $this->assertTrue($model->validate('explanation'));

        //lorem 1000 chars
        $model->explanation = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum scelerisque dui eget
            consequat bibendum. Maecenas in vestibulum dui. Mauris sagittis tincidunt felis eget malesuada. Duis elit eros,
            maximus sed sollicitudin ac, viverra vitae ligula. Vivamus vel blandit risus. Nunc sed convallis urna,
            eu accumsan massa. Donec a elit ut purus vestibulum cursus nec ornare sem.
            Ut feugiat nibh et lorem porta efficitur. Nulla convallis nunc quis tellus pellentesque, eu vehicula eros 
            gravida. Vivamus placerat vitae arcu dapibus fringilla. Maecenas auctor fringilla dolor, et molestie odio
            dictum quis. Integer ac nibh mauris. Nam a accumsan dui. Donec sit amet orci et urna mollis congue id in
            erat. Pellentesque eget tellus feugiat, hendrerit erat ac, efficitur eros. Vestibulum id purus eu lorem
            sodales sagittis eget at ante. Fusce tincidunt tempus neque vel dignissim. Phasellus eget elit ut enim ';
        $this->assertTrue($model->validate('explanation'));

        $model->explanation = '';
        $this->assertTrue($model->validate('explanation'));

        $model->explanation = null;
        $this->assertTrue($model->validate('explanation'));

        $model->explanation = false;
        $this->assertFalse($model->validate('explanation'));
    }
}
