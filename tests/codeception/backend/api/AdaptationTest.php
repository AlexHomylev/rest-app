<?php

namespace tests\codeception\backend\api;

use Codeception\Util\HttpCode;
use tests\codeception\backend\unit\TestCase;
use tests\codeception\common\fixtures\AdaptationFixture;
use tests\codeception\common\fixtures\AuthAssignmentFixture;
use tests\codeception\common\fixtures\UserFixture;
use tests\codeception\components\Collection;

class AdaptationTest extends TestCase
{
    protected $tester;

    public function fixtures()
    {
        return [
            'adaptation' => AdaptationFixture::class,
            'auth_assignment' => AuthAssignmentFixture::class,
            'user' => UserFixture::class,
        ];
    }

    public function testIndex()
    {
        $I = $this->tester;
        $I->sendGET('rest/adaptation');
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
        $I->amHttpAuthenticated(Collection::ADMIN_EMAIL, Collection::ADMIN_PASS);
        $I->sendGET('rest/adaptation');
        $I->seeResponseContainsJson([
            [
                'uid' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23ff',
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
                ],
                'created_at' => '2019-05-30 10:41:56',
                'updated_at' => '2019-05-30 10:41:56',
            ],
            [
                'uid' => 'ac0da11b-a5df-40cb-96bf-23716e066dd9',
                'title' => 'Оцениваем работу компании',
                'survey_type' => 1,
                'is_shuffle' => false,
                'questions' => [
                    [
                        'id' => 'ac0da11b-a5df-40cb-96bf-23716e066dd8',
                        'type' => 1,
                        'question' => 'Как вы оцениваете работу в компании?',
                        'explanation' => 'Укажите оценку',
                        'comment' => true
                    ],
                    [
                        'id' => 'ac0da11b-a5df-40cb-96bf-23716e066dd7',
                        'type' => 2,
                        'question' => 'Сколько вам лет?',
                        'explanation' => 'Укажите сколько вам лет',
                        'comment' => false
                    ],
                    [
                        'id' => 'ac0da11b-a5df-40cb-96bf-23716e066dd6',
                        'type' => 5,
                        'question' => 'Нравиться ли вам работа в компании?',
                        'explanation' => 'Nothing',
                        'answers' => [
                            ['title' => 'Да', 'id' => '1'],
                            ['title' => 'Нет', 'id' => '2'],
                            ['title' => 'Возможно', 'id' => '3'],
                            ['title' => 'Не уверен', 'id' => '4']
                        ],
                        'comment' => true
                    ]
                ],
                'created_at' => '2019-05-30 10:41:56',
                'updated_at' => '2019-05-30 10:41:56',
            ],
            [
                'uid' => 'bd9975f8-3c18-45db-ab2d-1523dbd87fd4',
                'title' => 'На сколько комфортно в компании коллег',
                'survey_type' => 3,
                'is_shuffle' => true,
                'questions' => [
                    [
                        'id' => 'bd9975f8-3c18-45db-ab2d-1523dbd87fd3',
                        'type' => 1,
                        'question' => 'На сколько вам комфортно в компании коллег?',
                        'explanation' => null,
                        'comment' => false
                    ],
                    [
                        'id' => 'bd9975f8-3c18-45db-ab2d-1523dbd87fd2',
                        'type' => 3,
                        'question' => 'Ваше любимое занятие вне работы, в компании коллег?',
                        'explanation' => 'Что чаще всего делаете вместе',
                        'comment' => true
                    ],
                    [
                        'id' => 'bd9975f8-3c18-45db-ab2d-1523dbd87fd1',
                        'type' => 4,
                        'question' => 'Что из перечисленных пунктов чаще всего ощущаете?',
                        'explanation' => null,
                        'answers' => [
                            ['title' => 'Радость', 'id' => '1'],
                            ['title' => 'Дискомфорт', 'id' => '2'],
                            ['title' => 'Нехватку пространство', 'id' => '3'],
                            ['title' => 'Невозможность сосредоточиться', 'id' => '4']
                        ],
                        'comment' => false
                    ]
                ],
                'created_at' => '2019-05-30 10:41:56',
                'updated_at' => '2019-05-30 10:41:56',
            ]
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function testIndexWithQuery()
    {
        $I = $this->tester;
        $I->amHttpAuthenticated(Collection::ADMIN_EMAIL, Collection::ADMIN_PASS);
        $I->sendGET('rest/adaptation?q=На сколько комфортно в компании коллег');
        $I->seeResponseContainsJson([
            [
                'uid' => 'bd9975f8-3c18-45db-ab2d-1523dbd87fd4',
                'title' => 'На сколько комфортно в компании коллег',
                'survey_type' => 3,
                'is_shuffle' => true,
                'questions' => [
                    [
                        'id' => 'bd9975f8-3c18-45db-ab2d-1523dbd87fd3',
                        'type' => 1,
                        'question' => 'На сколько вам комфортно в компании коллег?',
                        'explanation' => null,
                        'comment' => false
                    ],
                    [
                        'id' => 'bd9975f8-3c18-45db-ab2d-1523dbd87fd2',
                        'type' => 3,
                        'question' => 'Ваше любимое занятие вне работы, в компании коллег?',
                        'explanation' => 'Что чаще всего делаете вместе',
                        'comment' => true
                    ],
                    [
                        'id' => 'bd9975f8-3c18-45db-ab2d-1523dbd87fd1',
                        'type' => 4,
                        'question' => 'Что из перечисленных пунктов чаще всего ощущаете?',
                        'explanation' => null,
                        'answers' => [
                            ['title' => 'Радость', 'id' => '1'],
                            ['title' => 'Дискомфорт', 'id' => '2'],
                            ['title' => 'Нехватку пространство', 'id' => '3'],
                            ['title' => 'Невозможность сосредоточиться', 'id' => '4']
                        ],
                        'comment' => false
                    ]
                ],
                'created_at' => '2019-05-30 10:41:56',
                'updated_at' => '2019-05-30 10:41:56',
            ]
        ]);

        $I->sendGET('rest/adaptation?q=оцениваем');
        $I->seeResponseContainsJson([
            [
                'uid' => 'ac0da11b-a5df-40cb-96bf-23716e066dd9',
                'title'=> 'Оцениваем работу компании',
                'survey_type' => 1,
                'is_shuffle' => false,
                'questions' => [
                    [
                        'id' => 'ac0da11b-a5df-40cb-96bf-23716e066dd8',
                        'type' => 1,
                        'question' => 'Как вы оцениваете работу в компании?',
                        'explanation' => 'Укажите оценку',
                        'comment' => true
                    ],
                    [
                        'id' => 'ac0da11b-a5df-40cb-96bf-23716e066dd7',
                        'type' => 2,
                        'question' => 'Сколько вам лет?',
                        'explanation' => 'Укажите сколько вам лет',
                        'comment' => false
                    ],
                    [
                        'id' => 'ac0da11b-a5df-40cb-96bf-23716e066dd6',
                        'type' => 5,
                        'question' => 'Нравиться ли вам работа в компании?',
                        'explanation' => 'Nothing',
                        'answers' => [
                            ['title' => 'Да', 'id' => '1'],
                            ['title' => 'Нет', 'id' => '2'],
                            ['title' => 'Возможно', 'id' => '3'],
                            ['title' => 'Не уверен', 'id' => '4']
                        ],
                        'comment' => true
                    ]
                ],
                'created_at' => '2019-05-30 10:41:56',
                'updated_at' => '2019-05-30 10:41:56',
            ],
            [
                'uid' => 'bc0da21b-b6df-40cb-96bf-23716e166dd9',
                'title'=> 'Оцениваем работу коллег',
                'survey_type' => 1,
                'is_shuffle' => false,
                'questions' => [
                    [
                        'id' => 'bc0da11b-a6df-40cb-96bf-23716e066dd9',
                        'type' => 1,
                        'question' => 'Как вы оцениваете работу коллег?',
                        'explanation' => 'Укажите оценку',
                        'comment' => true
                    ],
                    [
                        'id' => 'bc0da11b-b6df-40cb-96bf-24716e066dd8',
                        'type' => 2,
                        'question' => 'Сколько вам лет?',
                        'explanation' => 'Укажите сколько вам лет',
                        'comment' => false
                    ],
                    [
                        'id' => 'bc0da11b-b6df-50cb-96bf-23716e066dd2',
                        'type' => 5,
                        'question' => 'Нравиться ли вам работать с такими коллегами?',
                        'explanation' => 'Nothing',
                        'answers' => [
                            ['title' => 'Да', 'id' => '1'],
                            ['title' => 'Нет', 'id' => '2'],
                            ['title' => 'Возможно', 'id' => '3'],
                            ['title' => 'Не уверен', 'id' => '4']
                        ],
                        'comment' => true
                    ]
                ],
                'created_at' => '2019-05-30 10:41:56',
                'updated_at' => '2019-05-30 10:41:56',
            ],
        ]);
    }

    public function testIndexWithQueryEmptyResult()
    {
        $I = $this->tester;
        $I->amHttpAuthenticated(Collection::ADMIN_EMAIL, Collection::ADMIN_PASS);
        $I->sendGET('rest/adaptation?q=Ferastilinor');
        $I->seeResponseContainsJson([]);
    }

    public function testView()
    {
        $I = $this->tester;
        $I->amHttpAuthenticated(Collection::ADMIN_EMAIL, Collection::ADMIN_PASS);
        $I->sendGET('rest/adaptation/649a9c4c-1b4b-46c9-932d-8a50f3ee23ff');
        $I->seeResponseContainsJson([
            'uid' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23ff',
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
            ],
            'created_at' => '2019-05-30 10:41:56',
            'updated_at' => '2019-05-30 10:41:56',
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function testCreate()
    {
        $I = $this->tester;
        $I->amHttpAuthenticated(Collection::ADMIN_EMAIL, Collection::ADMIN_PASS);
        $I->sendPOST('rest/adaptation', [
            'uid' => '8dbcf279-4739-4fbb-b92c-967f2f2928fc',
            'title' => 'Хочу сделать тест!',
            'style' => 'driver',
            'survey_type' => 2,
            'explanation' => 'Тестовое описание тестовой анкеты.',
            'is_shuffle' => true,
            'questions' => [
                [
                    'id' => '8dbcf279-4739-4fbb-b92c-967f2f2928fa',
                    'type' => 1,
                    'question' => 'Как вы оцениваете работу в компании?',
                    'explanation' => 'Укажите оценку',
                    'comment' => true,
                    'is_hidden' => false,
                    'view' => 'stars',
                    'is_not_required' => true,
                ],
                [
                    'id' => '832344d0-c002-11ea-b812-00155d4b4818',
                    'question' => 'Ваша Фамилия',
                    'explanation' => '',
                    'comment' => false,
                    'type' => 3,
                    'placeholder' => 'Иванов',
                    'is_hidden' => false,
                    'view' => 'stars',
                    'is_not_required' => true,
                ],
                [
                    'id' => '8dbcf279-4739-4fbb-b92c-967f2f2928fb',
                    'type' => 2,
                    'question' => 'Сколько вам лет?',
                    'explanation' => 'Укажите сколько вам лет',
                    'comment' => false,
                    'hint' => 'age-box',
                    'match' => '[{1-100}]',
                    'is_hidden' => false,
                    'view' => 'stars',
                    'is_not_required' => true,
                ],
                [
                    'id' => '8dbcf279-4739-4fbb-b92c-967f2f2928fc',
                    'type' => 5,
                    'question' => 'Нравиться ли вам работа в компании?',
                    'explanation' => 'Nothing',
                    'answers' => [
                        ['title' => 'Да', 'id' => '1'],
                        ['title' => 'Нет', 'id' => '2'],
                        ['title' => 'Возможно', 'id' => '3'],
                        ['title' => 'Не уверен', 'id' => '4']
                    ],
                    'comment' => true,
                    'is_hidden' => true,
                    'view' => 'stars',
                    'is_not_required' => true,
                ],
                [
                    'id' => '8dbcf279-4739-4fbb-b92c-967f2f2928fd',
                    'type' => 6,
                    'question' => 'Приложите фотографии документов, для проверки вашей личности.',
                    'explanation' => 'Приложите 4 фотографии',
                    'comment' => true,
                    'count' => 4,
                    'is_hidden' => true,
                    'view' => 'stars',
                    'is_not_required' => true,
                ],
                [
                    'id' => '8dbcf279-4739-4fbb-b92c-967f2f2928fe',
                    'type' => 6,
                    'question' => 'Приложите фотографии вашего автомобиля.',
                    'explanation' => 'От 4 до 8 фотографий',
                    'comment' => true,
                    'min_count' => 4,
                    'max_count' => 8,
                    'is_hidden' => false,
                    'view' => 'stars',
                    'is_not_required' => true,
                ]
            ]
        ]);

        $I->seeResponseContainsJson([
            'uid' => '8dbcf279-4739-4fbb-b92c-967f2f2928fc',
            'title' => 'Хочу сделать тест!',
            'style' => 'driver',
            'survey_type' => 2,
            'explanation' => 'Тестовое описание тестовой анкеты.',
            'is_shuffle' => '1',
            'questions' => [
                [
                    'id' => '8dbcf279-4739-4fbb-b92c-967f2f2928fa',
                    'type' => '1',
                    'question' => 'Как вы оцениваете работу в компании?',
                    'explanation' => 'Укажите оценку',
                    'comment' => '1',
                    'answers' => null,
                    'count' => null,
                    'is_hidden' => '0',
                    'view' => 'stars',
                    'is_not_required' => '1',
                ],
                [
                    'id' => '832344d0-c002-11ea-b812-00155d4b4818',
                    'question' => 'Ваша Фамилия',
                    'explanation' => '',
                    'comment' => '0',
                    'type' => '3',
                    'placeholder' => 'Иванов',
                    'is_hidden' => '0',
                    'view' => 'stars',
                    'is_not_required' => '1',
                ],
                [
                    'id' => '8dbcf279-4739-4fbb-b92c-967f2f2928fb',
                    'type' => '2',
                    'question' => 'Сколько вам лет?',
                    'explanation' => 'Укажите сколько вам лет',
                    'comment' => '0',
                    'answers' => null,
                    'count' => null,
                    'hint' => 'age-box',
                    'match' => '[{1-100}]',
                    'is_hidden' => '0',
                    'view' => 'stars',
                    'is_not_required' => '1',

                ],
                [
                    'id' => '8dbcf279-4739-4fbb-b92c-967f2f2928fc',
                    'type' => '5',
                    'question' => 'Нравиться ли вам работа в компании?',
                    'explanation' => 'Nothing',
                    'comment' => '1',
                    'is_hidden' => '1',
                    'view' => 'stars',
                    'is_not_required' => '1',
                    'answers' => [
                        ['title' => 'Да', 'id' => '1'],
                        ['title' => 'Нет', 'id' => '2'],
                        ['title' => 'Возможно', 'id' => '3'],
                        ['title' => 'Не уверен', 'id' => '4']
                    ],
                ],
                [
                    'id' => '8dbcf279-4739-4fbb-b92c-967f2f2928fd',
                    'type' => '6',
                    'question' => 'Приложите фотографии документов, для проверки вашей личности.',
                    'explanation' => 'Приложите 4 фотографии',
                    'comment' => '1',
                    'count' => '4',
                    'is_hidden' => '1',
                    'view' => 'stars',
                    'is_not_required' => '1',
                ],
                [
                    'id' => '8dbcf279-4739-4fbb-b92c-967f2f2928fe',
                    'type' => '6',
                    'question' => 'Приложите фотографии вашего автомобиля.',
                    'explanation' => 'От 4 до 8 фотографий',
                    'comment' => '1',
                    'min_count' => '4',
                    'max_count' => '8',
                    'is_hidden' => '0',
                    'view' => 'stars',
                    'is_not_required' => '1',
                ]
            ],
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
    }

    public function testFailCreate()
    {
        $I = $this->tester;
        $I->amHttpAuthenticated(Collection::ADMIN_EMAIL, Collection::ADMIN_PASS);
        $I->sendPOST('rest/adaptation', [
            'uid' => '8dbcf279-4739-4fbb-b92c-967f2f2928fc',
            'title' => 'Хочу сделать тест!',
            'style' => 'latex',
        ]);

        $I->seeResponseContainsJson([
            [
                'field' => 'style',
                'message' => 'Значение «Стиль» неверно.',
            ],
            [
                'field' => 'questions',
                'message' => 'Необходимо заполнить «Вопросы».',
            ],
        ]);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);

    }

    public function testUpdate()
    {
        $I = $this->tester;
        $I->amHttpAuthenticated(Collection::ADMIN_EMAIL, Collection::ADMIN_PASS);
        $I->sendPUT('rest/adaptation/ac0da11b-a5df-40cb-96bf-23716e066dd9', [
            'title' => 'Первый ИЗМЕНЁННЫЙ в мире тест!',
            'style' => 'driver',
            'explanation' => 'Новое тестовое описание тестовой анкеты.',
            'is_shuffle' => false,
            'questions' => [
                [
                    'id' => 'ac0da11b-a5df-40cb-96bf-23716e066dd8',
                    'type' => 1,
                    'question' => 'Как вы оцениваете работу в компании?',
                    'explanation' => 'Укажите оценку',
                    'comment' => true,
                    'is_not_required' => false,
                ],
                [
                    'id' => 'ac0da11b-a5df-40cb-96bf-23716e066dd7',
                    'type' => 2,
                    'question' => 'Сколько вам лет?',
                    'explanation' => 'Укажите сколько вам лет',
                    'comment' => false,
                    'is_not_required' => false,
                ],
                [
                    'id' => 'ac0da11b-a5df-40cb-96bf-23716e066dd6',
                    'type' => 5,
                    'question' => 'Нравиться ли вам работа в компании?',
                    'explanation' => 'Nothing',
                    'answers' => [
                        ['title' => 'Да', 'id' => '1'],
                        ['title' => 'Нет', 'id' => '2'],
                        ['title' => 'Возможно', 'id' => '3'],
                        ['title' => 'Не уверен', 'id' => '4']
                    ],
                    'comment' => true,
                    'is_not_required' => false,
                ]
            ]
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson([
            'title' => 'Первый ИЗМЕНЁННЫЙ в мире тест!',
            'explanation' => 'Новое тестовое описание тестовой анкеты.',
            'style' => 'driver',
            'is_shuffle' => '0',
        ]);
    }

    public function testDelete()
    {
        $I = $this->tester;
        $I->amHttpAuthenticated(Collection::ADMIN_EMAIL, Collection::ADMIN_PASS);
        $I->sendDelete('rest/adaptation/ac0da11b-a5df-40cb-96bf-23716e066dd9');
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }
}
