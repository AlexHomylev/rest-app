<?php

namespace tests\codeception\backend\unit;

use common\models\Adaptation;
use tests\codeception\common\fixtures\AdaptationFixture;

class AdaptationTest extends TestCase
{
    protected $tester;

    public function fixtures()
    {
        return [
            'adaptation' => AdaptationFixture::class,
        ];
    }

    public function testUid()
    {
        $model = new Adaptation();

        $model->uid = 'f75211a7-441c-45a2-8b91-f879602b20f0';
        $this->assertTrue($model->validate('uid'));

        $model->uid = 124124124124124124;
        $this->assertFalse($model->validate('uid'));

        $model->uid = 'wsdg3423234f4hiu43g3gi3';
        $this->assertFalse($model->validate('uid'));

        $model->uid = null;
        $this->assertFalse($model->validate('uid'));
    }

    public function testName()
    {
        $model = new Adaptation();

        $model->title = 'Самый настоящий курс!';
        $this->assertTrue($model->validate('title'));

        $model->title = 232352352352;
        $this->assertFalse($model->validate('title'));
    }

    public function testQuestions()
    {
        $model = new Adaptation();

        $model->questions = [
            [
                'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23da',
                'type' => 1,
                'question' => 'Вопрос с оценочной шкалой от 0 до 10.',
                'explanation' => 'Пояснение',
                'comment' => true,
                'is_not_required' => true,
            ],
            [
                'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23db',
                'type' => 2,
                'question' => 'Вопрос с вводом числа.',
                'explanation' => 'Пояснение',
                'comment' => false,
                'is_not_required' => true,
            ],
            [
                'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23dc',
                'type' => 3,
                'question' => 'Вопрос со свободным комментарием.',
                'explanation' => 'Пояснение',
                'comment' => false,
                'is_not_required' => false,
            ],
            [
                'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23dd',
                'type' => 4,
                'question' => 'Вопрос с выбором нескольких вариантов ответа.',
                'explanation' => 'Пояснение',
                'answers' => [
                    ['title' => 'Первый вариант', 'id' => '1'],
                    ['title' => 'Второй вариант', 'id' => '2'],
                    ['title' => 'Третий вариант', 'id' => '3'],
                    ['title' => 'Четвёртый вариант', 'id' => '4']
                ],
                'comment' => false,
                'is_not_required' => true,
            ],
            [
                'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23de',
                'type' => 5,
                'question' => 'Вопрос с выбором одного варианта ответа.',
                'explanation' => 'Пояснение',
                'answers' => [
                    ['title' => 'Первый вариант', 'id' => '1'],
                    ['title' => 'Второй вариант', 'id' => '2'],
                    ['title' => 'Третий вариант', 'id' => '3'],
                    ['title' => 'Четвёртый вариант', 'id' => '4']
                ],
                'comment' => true,
                'is_not_required' => false,
            ]
        ];
        $this->assertTrue($model->validate('questions'));
    }

    /**
     * @dataProvider questions
     */
    public function testQuestionsWithFile($questions, $result)
    {
        $model = new Adaptation();
        $model->setQuestions($questions);
        $this->assertEquals($result, $model->isWithFiles());
    }

    /**
     * @return array
     */
    public function questions()
    {
        return [
            ['questions' => [
                [
                    'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23da',
                    'type' => 1,
                    'question' => 'Вопрос с оценочной шкалой от 0 до 10.',
                    'explanation' => 'Пояснение',
                    'comment' => true,
                    'is_not_required' => true,
                ],
                [
                    'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23db',
                    'type' => 2,
                    'question' => 'Вопрос с вводом числа.',
                    'explanation' => 'Пояснение',
                    'comment' => false,
                    'is_not_required' => true,
                ],
                [
                    'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23dc',
                    'type' => 6,
                    'question' => 'Вопрос с файликами',
                    'explanation' => 'Пояснение',
                    'comment' => false,
                    'is_not_required' => false,
                ],
            ], 'result' => true],
            ['questions' => [
                [
                    'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23da',
                    'type' => 1,
                    'question' => 'Вопрос с оценочной шкалой от 0 до 10.',
                    'explanation' => 'Пояснение',
                    'comment' => true,
                    'is_not_required' => true,
                ],
                [
                    'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23db',
                    'type' => 2,
                    'question' => 'Вопрос с вводом числа.',
                    'explanation' => 'Пояснение',
                    'comment' => false,
                    'is_not_required' => true,
                ],
                [
                    'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23dc',
                    'type' => 5,
                    'question' => 'Вопрос со свободным комментарием.',
                    'explanation' => 'Пояснение',
                    'comment' => false,
                    'is_not_required' => false,
                ],
            ], 'result' => false],
        ];
    }
}