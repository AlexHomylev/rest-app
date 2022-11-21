<?php

namespace tests\codeception\frontend;

use tests\codeception\common\fixtures\AdaptationAnswersFixture;
use tests\codeception\common\fixtures\AdaptationFixture;
use tests\codeception\frontend\unit\TestCase;


class AdaptationTest extends TestCase
{
    public function fixtures()
    {
        return [
            'adaptation' => AdaptationFixture::class,
            'adaptation_answers' => AdaptationAnswersFixture::class,
        ];
    }

    /**
     * @var \tests\codeception\frontend\ApiTester
     */
    protected $tester;

    public function testView()
    {
        $I = $this->tester;
        $I->sendGET('rest/adaptation/649a9c4c-1b4b-46c9-932d-8a50f3ee23ff');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'title' => 'Тестовый тест',
            'explanation' => 'Тестовое описание тестовой анкеты.',
            'style' => 'normal',
            'survey_type' => 1,
            'is_shuffle' => true,
            'questions' => [
                [
                    'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23da',
                    'type' => 1,
                    'question' => 'Вопрос с оценочной шкалой от 0 до 10.',
                    'explanation' => 'Пояснение',
                    'is_hidden' => false,
                    'view' => 'stars',
                    'comment' => true
                ],
                [
                    'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23db',
                    'type' => 2,
                    'question' => 'Вопрос с вводом числа.',
                    'explanation' => 'Пояснение',
                    'is_hidden' => false,
                    'view' => 'stars',
                    'comment' => false
                ],
                [
                    'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23dc',
                    'type' => 3,
                    'question' => 'Вопрос со свободным комментарием.',
                    'explanation' => 'Пояснение',
                    'is_hidden' => true,
                    'view' => 'stars',
                    'comment' => false
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
                    'is_hidden' => true,
                    'view' => 'stars',
                    'comment' => false
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
                    'is_hidden' => false,
                    'view' => 'stars',
                    'comment' => true
                ]
            ]
        ]);
    }

    public function testViewFail()
    {
        $I = $this->tester;
        $I->sendGET('rest/adaptation');
        $I->seeResponseCodeIs(404);

        $I->sendGET('rest/adaptation/076e2b2e-a0eb-4259-a2a9-d4da78dc9388');
        $I->seeResponseContainsJson([
            'message' => 'Форма с таким UID не найдена.'
        ]);
        $I->seeResponseCodeIs(404);

        $I->sendGET('rest/adaptation/1234567');
        $I->seeResponseContainsJson([
            'message' => 'Получен некоректный UID.'
        ]);
        $I->seeResponseCodeIs(404);
    }

    public function testCreateAnswer()
    {
        $I = $this->tester;
        $I->sendPOST('rest/adaptation/649a9c4c-1b4b-46c9-932d-8a50f3ee23ff/answers', [
            'answers' => [
                [
                    'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23da',
                    'type' => 1,
                    'answer'=> 7,
                    'comment' => 'Комментарий'
                ],
                [
                    'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23db',
                    'type' => 2,
                    'answer'=> 26
                ],
                [
                    'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23dc',
                    'type' => 3,
                    'answer'=> 'Ответ на вопрос текстом'
                ],
                [
                    'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23dd',
                    'type' => 4,
                    'answer' => [
                        '3',
                        '4'
                    ],
                ],
                [
                    'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23de',
                    'type' => 5,
                    'answer' => [
                        '4'
                    ],
                    'comment' => 'Комментарий'
                ]
            ]
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'answers' => [
                [
                    'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23da',
                    'type' => 1,
                    'answer'=> 7,
                    'comment' => 'Комментарий'
                ],
                [
                    'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23db',
                    'type' => 2,
                    'answer'=> 26
                ],
                [
                    'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23dc',
                    'type' => 3,
                    'answer'=> 'Ответ на вопрос текстом'
                ],
                [
                    'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23dd',
                    'type' => 4,
                    'answer' => [
                        '3',
                        '4'
                    ],
                ],
                [
                    'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23de',
                    'type' => 5,
                    'answer' => [
                        '4'
                    ],
                    'comment' => 'Комментарий'
                ]
            ]
        ]);
    }

    public function testCreateAnswerFail()
    {
        $I = $this->tester;
        $I->sendPOST('rest/adaptation/649a9c4c-1b4b-46c9-932d-8a50f3ee23ff/answers', [
            'answers' => [
                [
                    'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23da',
                    'type' => 1,
                    'answer'=> null,
                    'comment' => 'Комментарий'
                ],
                [
                    'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23db',
                    'type' => 2,
                    'answer'=> 26
                ],
                [
                    'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23dc',
                    'type' => 3,
                    'answer'=> 'Ответ на вопрос текстом'
                ],
                [
                    'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23dd',
                    'type' => 4,
                    'answer' => [
                        '3',
                        '4'
                    ],
                ],
                [
                    'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23de',
                    'type' => 5,
                    'answer' => [
                        '4'
                    ],
                    'comment' => 'Комментарий'
                ]
            ]
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
            [
                'field' => 'answer.649a9c4c-1b4b-46c9-932d-8a50f3ee23da.answer',
                'message' => 'Пожалуйста, ответьте на вопрос.'
            ]
        ]);
    }
}
