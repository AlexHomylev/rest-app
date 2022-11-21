<?php

use tests\codeception\common\fixtures\AdaptationAnswersFixture;
use tests\codeception\common\fixtures\AdaptationFixture;
use tests\codeception\frontend\unit\TestCase;

class AdaptationAnswersTest extends TestCase
{
    public function fixtures()
    {
        return [
            'adaptation' => AdaptationFixture::class,
            'adaptation_answers' => AdaptationAnswersFixture::class,
        ];
    }

    public function testView()
    {
        $I = $this->tester;
        $I->sendGET('rest/adaptation-answers/b42afd0a-01ef-4787-848d-160894d8e7cb');
        $I->seeResponseContainsJson([
            'uid' => 'b42afd0a-01ef-4787-848d-160894d8e7cb',
            'title' => 'Тестовый тест',
            'adaptation' => [
                'style' => 'normal',
                'explanation' => 'Тестовое описание тестовой анкеты.',
                'is_shuffle' => true,
                'questions' => [
                    [
                        'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23da',
                        'type' => 1,
                        'question' => 'Вопрос с оценочной шкалой от 0 до 10.',
                        'explanation' => 'Пояснение',
                        'comment' => true
                    ],
                    [
                        'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23db',
                        'type' => 2,
                        'question' => 'Вопрос с вводом числа.',
                        'explanation' => 'Пояснение',
                        'comment' => false
                    ],
                    [
                        'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23dc',
                        'type' => 3,
                        'question' => 'Вопрос со свободным комментарием.',
                        'explanation' => 'Пояснение',
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
                        'comment' => true
                    ]
                ]
            ],
            'username' => 'Papa Jons',
            'is_processed' => false,
            'answers' => [],
        ]);
        $I->seeResponseCodeIs(200);
    }

    public function testViewWithCustomTitle()
    {
        $I = $this->tester;
        $I->sendGET('rest/adaptation-answers/2af00090-29ec-4e1c-a259-a1fa8368c5a1');
        $I->seeResponseContainsJson([
            'uid' => '2af00090-29ec-4e1c-a259-a1fa8368c5a1',
            'title' => 'Назначение с особым заголовком',
            'adaptation' => [
                'style' => 'normal',
                'explanation' => null,
                'is_shuffle' => false,
                'questions' => [
                    [
                        'id' => 'f9ddc6f3-4bdc-45a9-a26d-df79e385de02',
                        'type' => 3,
                        'question' => 'Укажите марку и модель вашего автомобиля.',
                        'explanation' => null,
                        'comment' => false
                    ],
                    [
                        'id' => 'f9ddc6f3-4bdc-45a9-a26d-df79e385de03',
                        'type' => 6,
                        'question' => 'Загрузите фотографию вашего паспорта',
                        'explanation' => null,
                        'count' => 1,
                        'comment' => false
                    ],
                    [
                        'id' => 'f9ddc6f3-4bdc-45a9-a26d-df79e385de04',
                        'type' => 6,
                        'question' => 'Загрузите обе стороны вашего водительского удостоверения',
                        'explanation' => null,
                        'count' => 2,
                        'comment' => false
                    ]
                ],
            ],
            'username' => 'Kalina Mashina',
            'is_processed' => false,
        ]);
        $I->seeResponseCodeIs(200);
    }

    public function testViewByDeviceID() {
        $I = $this->tester;
        $I->sendGET('rest/adaptation-answers/3');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'uid' => 'b42afd0a-01ef-4787-848d-160894d8e7cb',
            'title' => 'Тестовый тест',
            'adaptation' => [
                'style' => 'normal',
                'is_shuffle' => true,
                'questions' => [
                    [
                        'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23da',
                        'type' => 1,
                        'question' => 'Вопрос с оценочной шкалой от 0 до 10.',
                        'explanation' => 'Пояснение',
                        'comment' => true
                    ],
                    [
                        'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23db',
                        'type' => 2,
                        'question' => 'Вопрос с вводом числа.',
                        'explanation' => 'Пояснение',
                        'comment' => false
                    ],
                    [
                        'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23dc',
                        'type' => 3,
                        'question' => 'Вопрос со свободным комментарием.',
                        'explanation' => 'Пояснение',
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
                        'comment' => true
                    ]
                ]
            ],
            'username' => 'Papa Jons',
            'is_processed' => false,
            'answers' => [],
            'open_at' => '2019-04-21 09:25:37',
        ]);
    }

    public function testViewFail()
    {
        $I = $this->tester;
        $I->sendGET('rest/adaptation-answers');
        $I->seeResponseCodeIs(404);

        $I->sendGET('rest/adaptation-answers/076e2b2e-a0eb-4259-a2a9-d4da78dc9388');
        $I->seeResponseContainsJson([
            'message' => 'Назначения для теста с таким UID или DeviceID не найдена.'
        ]);
        $I->seeResponseCodeIs(404);

        $I->sendGET('rest/adaptation-answers/076e2b2e-a0eb-4259-a2a9-d4da78dc9248');
        $I->seeResponseContainsJson([
            'message' => 'Тест уже выполнен.'
        ]);
        $I->seeResponseCodeIs(422);
    }

    public function testCreateAnswer()
    {
        $I = $this->tester;
        $I->sendPOST('rest/adaptation-answers/b42afd0a-01ef-4787-848d-160894d8e7cb', [
            'open_at' => '2021-02-25 11:04:00',
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
        $I->seeResponseContainsJson([
            'uid' => 'b42afd0a-01ef-4787-848d-160894d8e7cb',
            'title' => 'Тестовый тест',
            'adaptation' => [
                'style' => 'normal',
                'questions' => [
                    [
                        'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23da',
                        'type' => 1,
                        'question' => 'Вопрос с оценочной шкалой от 0 до 10.',
                        'explanation' => 'Пояснение',
                        'comment' => true
                    ],
                    [
                        'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23db',
                        'type' => 2,
                        'question' => 'Вопрос с вводом числа.',
                        'explanation' => 'Пояснение',
                        'comment' => false
                    ],
                    [
                        'id' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23dc',
                        'type' => 3,
                        'question' => 'Вопрос со свободным комментарием.',
                        'explanation' => 'Пояснение',
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
                        'comment' => true
                    ]
                ]
            ],
            'username' => 'Papa Jons',
            'is_processed' => false,
            'open_at' => '2021-02-25 11:04:00',
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
    }

    public function testCreateAnswerFail()
    {
        $I = $this->tester;
        $I->sendPOST('rest/adaptation-answers/b42afd0a-01ef-4787-848d-160894d8e7cb', [
            'answers' => [
                [
                    'id'=> '649a9c4c-1b4b-46c9-932d-8a50f3ee23da',
                    'ty'=> 1,
                    'comment'=> 'How i can do it?',
                    'answer'=> 33
                ],
                [
                    'id'=> '649a9c4c-1b4b-46c9-932d-8a50f3ee23db',
                    'type'=> 2,
                    'comment'=> 'How i can do it?',
                    'answer'=> 'Pretty izi my frien'
                ],
                [
                    'id'=> '649a9c4c-1b4b-46c9-932d-8a50f3ee23dc',
                    'type'=> 5,
                    'comment'=> 'How i can do it?',
                    'answer'=> [
                        '1',
                        '2'
                    ]
                ]
            ]
        ]);
        $I->seeResponseContainsJson([
            [
            'field' => 'answer.649a9c4c-1b4b-46c9-932d-8a50f3ee23da.type',
            'message' => 'Необходимо заполнить «Type».'
            ]
        ]);
        $I->seeResponseCodeIs(422);
    }

    public function testCreateAnswerWithFiles()
    {
        $I = $this->tester;
        $I->sendPOST('rest/adaptation-answers/1df00090-29ec-4e1c-a259-a1fa8368c5f8',
            [
                'open_at' => '2021-02-25 10:30:00',
                'answers' => [
                    [
                        'id'=> 'f9ddc6f3-4bdc-45a9-a26d-df79e385de02',
                        'type'=> 3,
                        'answer'=> 'Lada Kalina'
                    ],
                    [
                        'id'=> 'f9ddc6f3-4bdc-45a9-a26d-df79e385de03',
                        'type'=> 6,
                        'answer'=> [],
                    ],
                    [
                        'id'=> 'f9ddc6f3-4bdc-45a9-a26d-df79e385de04',
                        'type'=> 6,
                        'answer'=> [],
                        'comment'=> 'Интересный вопрос',
                    ]
                ]
            ],
            [
                'files' => [
                    codecept_data_dir('f9ddc6f3-4bdc-45a9-a26d-df79e385de03_1.png'),
                    codecept_data_dir('f9ddc6f3-4bdc-45a9-a26d-df79e385de04_1.jpeg'),
                    codecept_data_dir('f9ddc6f3-4bdc-45a9-a26d-df79e385de04_2.png'),
                ],
            ]
        );
        $I->seeResponseContainsJson([
            'uid' => '1df00090-29ec-4e1c-a259-a1fa8368c5f8',
            'title'=> 'Тест для автолюбителей',
            'adaptation' => [
                'style' => 'normal',
                'questions' => [
                    [
                        'id' => 'f9ddc6f3-4bdc-45a9-a26d-df79e385de02',
                        'type' => 3,
                        'question' => 'Укажите марку и модель вашего автомобиля.',
                        'explanation' => null,
                        'comment' => false
                    ],
                    [
                        'id' => 'f9ddc6f3-4bdc-45a9-a26d-df79e385de03',
                        'type' => 6,
                        'question' => 'Загрузите фотографию вашего паспорта',
                        'explanation' => null,
                        'count' => 1,
                        'comment' => false
                    ],
                    [
                        'id' => 'f9ddc6f3-4bdc-45a9-a26d-df79e385de04',
                        'type' => 6,
                        'question' => 'Загрузите обе стороны вашего водительского удостоверения',
                        'explanation' => null,
                        'count' => 2,
                        'comment' => false
                    ]
                ]
            ],
            'username' => 'Kalina Mashina',
            'is_processed' => false,
            'answers' => [
                [
                    'id'=> 'f9ddc6f3-4bdc-45a9-a26d-df79e385de02',
                    'type'=> '3',
                    'answer'=> 'Lada Kalina'
                ],
                [
                    'id'=> 'f9ddc6f3-4bdc-45a9-a26d-df79e385de03',
                    'type'=> '6',
                    'answer'=> [
                        '/files/adaptation/1df00090-29ec-4e1c-a259-a1fa8368c5f8/f9ddc6f3-4bdc-45a9-a26d-df79e385de03/1.png'
                    ]
                ],
                [
                    'id'=> 'f9ddc6f3-4bdc-45a9-a26d-df79e385de04',
                    'type'=> '6',
                    'comment'=> 'Интересный вопрос',
                    'answer'=> [
                        '/files/adaptation/1df00090-29ec-4e1c-a259-a1fa8368c5f8/f9ddc6f3-4bdc-45a9-a26d-df79e385de04/1.jpeg',
                        '/files/adaptation/1df00090-29ec-4e1c-a259-a1fa8368c5f8/f9ddc6f3-4bdc-45a9-a26d-df79e385de04/2.png'
                    ]
                ]
            ],
            'device_id' => 54,
            'open_at' => '2021-02-25 10:30:00',
        ]);
        $I->seeResponseCodeIs(200);
    }

    public function testCreateAnswerWithBigFileError()
    {
        $I = $this->tester;
        $I->sendPOST('rest/adaptation-answers/1df00090-29ec-4e1c-a259-a1fa8368c5f8',
            [
                'answers' => [
                    [
                        'id'=> 'f9ddc6f3-4bdc-45a9-a26d-df79e385de02',
                        'type'=> 3,
                        'answer'=> 'Lada Kalina'
                    ],
                    [
                        'id'=> 'f9ddc6f3-4bdc-45a9-a26d-df79e385de03',
                        'type'=> 6,
                        'answer'=> [],
                    ],
                    [
                        'id'=> 'f9ddc6f3-4bdc-45a9-a26d-df79e385de04',
                        'type'=> 6,
                        'answer'=> [],
                        'comment'=> 'Интересный вопрос',
                    ]
                ]
            ],
            [
                'files' => [
                    codecept_data_dir('f9ddc6f3-4bdc-45a9-a26d-df79e385de03_1.png'),
                    codecept_data_dir('f9ddc6f3-4bdc-45a9-a26d-df79e385de03_2.jpg'),
                    codecept_data_dir('f9ddc6f3-4bdc-45a9-a26d-df79e385de04_1.jpeg'),
                ],
            ]
        );
        $I->seeResponseContainsJson([
            [
                'field' => 'files',
                'message' => 'Файл «f9ddc6f3-4bdc-45a9-a26d-df79e385de03_2.jpg» слишком большой. Размер не должен превышать 15 МиБ.'
            ]
        ]);
        $I->seeResponseCodeIs(422);
    }

    public function testCreateAnswerWithFilesEmptyRequest()
    {
        $I = $this->tester;
        $I->sendPOST('rest/adaptation-answers/1df00090-29ec-4e1c-a259-a1fa8368c5f8',
            [
                // пусто
            ],
            [
                'files' => [
                    codecept_data_dir('f9ddc6f3-4bdc-45a9-a26d-df79e385de03_1.png'),
                    codecept_data_dir('f9ddc6f3-4bdc-45a9-a26d-df79e385de04_1.jpeg'),
                    codecept_data_dir('f9ddc6f3-4bdc-45a9-a26d-df79e385de04_2.png'),
                ],
            ]
        );
        $I->seeResponseContainsJson([
            [
                'message' => 'Пожалуйста, ответьте на все вопросы.',
                'field' => 'answers'
            ]
        ]);
        $I->seeResponseCodeIs(422);
    }

}
