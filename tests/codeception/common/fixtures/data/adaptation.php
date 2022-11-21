<?php

return [
    [
        'uid' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23ff',
	    'title' => 'Тестовый тест',
        'explanation' => 'Тестовое описание тестовой анкеты.',
        'style' => 'normal',
        'survey_type' => 1,
        'is_shuffle' => true,
        'form_jsonb' => [
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
    ],
    [
        'uid' => 'ac0da11b-a5df-40cb-96bf-23716e066dd9',
        'title'=> 'Оцениваем работу компании',
        'style' => 'normal',
        'survey_type' => 1,
        'is_shuffle' => false,
        'form_jsonb' => [
            [
                'id' => 'ac0da11b-a5df-40cb-96bf-23716e066dd8',
                'type' => 1,
                'question' => 'Как вы оцениваете работу в компании?',
                'explanation' => 'Укажите оценку',
                'is_hidden' => false,
                'view' => 'stars',
                'comment' => true
            ],
            [
                'id' => 'ac0da11b-a5df-40cb-96bf-23716e066dd7',
                'type' => 2,
                'question' => 'Сколько вам лет?',
                'explanation' => 'Укажите сколько вам лет',
                'is_hidden' => false,
                'view' => 'stars',
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
                'is_hidden' => false,
                'view' => 'stars',
                'comment' => true
            ]
        ],
        'created_at' => '2019-05-30 10:41:56',
        'updated_at' => '2019-05-30 10:41:56',
    ],
    [
        'uid' => 'bd9975f8-3c18-45db-ab2d-1523dbd87fd4',
        'title'=> 'На сколько комфортно в компании коллег',
        'style' => 'normal',
        'survey_type' => 3,
        'is_shuffle' => true,
        'form_jsonb' => [
            [
                'id' => 'bd9975f8-3c18-45db-ab2d-1523dbd87fd3',
                'type' => 1,
                'question' => 'На сколько вам комфортно в компании коллег?',
                'explanation' => null,
                'is_hidden' => false,
                'view' => 'stars',
                'comment' => false
            ],
            [
                'id' => 'bd9975f8-3c18-45db-ab2d-1523dbd87fd2',
                'type' => 3,
                'question' => 'Ваше любимое занятие вне работы, в компании коллег?',
                'explanation' => 'Что чаще всего делаете вместе',
                'is_hidden' => true,
                'view' => 'stars',
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
                'is_hidden' => false,
                'view' => 'stars',
                'comment' => false
            ]
        ],
        'created_at' => '2019-05-30 10:41:56',
        'updated_at' => '2019-05-30 10:41:56',
    ],
    [
        'uid' => 'f9ddc6f3-4bdc-45a9-a26d-df79e385de01',
        'title'=> 'Тест для автолюбителей',
        'style' => 'normal',
        'survey_type' => null,
        'is_shuffle' => false,
        'form_jsonb' => [
            [
                'id' => 'f9ddc6f3-4bdc-45a9-a26d-df79e385de02',
                'type' => 3,
                'question' => 'Укажите марку и модель вашего автомобиля.',
                'explanation' => null,
                'is_hidden' => false,
                'view' => 'stars',
                'comment' => false
            ],
            [
                'id' => 'f9ddc6f3-4bdc-45a9-a26d-df79e385de03',
                'type' => 6,
                'question' => 'Загрузите фотографию вашего паспорта',
                'explanation' => null,
                'count' => 1,
                'is_hidden' => false,
                'view' => 'stars',
                'comment' => false
            ],
            [
                'id' => 'f9ddc6f3-4bdc-45a9-a26d-df79e385de04',
                'type' => 6,
                'question' => 'Загрузите обе стороны вашего водительского удостоверения',
                'explanation' => null,
                'count' => 2,
                'is_hidden' => false,
                'view' => 'stars',
                'comment' => false
            ]
        ],
        'created_at' => '2019-05-30 10:41:56',
        'updated_at' => '2019-05-30 10:41:56',
    ],
    [
        'uid' => 'bc0da21b-b6df-40cb-96bf-23716e166dd9',
        'title'=> 'Оцениваем работу коллег',
        'style' => 'normal',
        'survey_type' => 1,
        'is_shuffle' => false,
        'form_jsonb' => [
            [
                'id' => 'bc0da11b-a6df-40cb-96bf-23716e066dd9',
                'type' => 1,
                'question' => 'Как вы оцениваете работу коллег?',
                'explanation' => 'Укажите оценку',
                'is_hidden' => false,
                'view' => 'stars',
                'comment' => true
            ],
            [
                'id' => 'bc0da11b-b6df-40cb-96bf-24716e066dd8',
                'type' => 2,
                'question' => 'Сколько вам лет?',
                'explanation' => 'Укажите сколько вам лет',
                'is_hidden' => false,
                'view' => 'stars',
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
                'is_hidden' => false,
                'view' => 'stars',
                'comment' => true
            ]
        ],
        'created_at' => '2019-05-30 10:41:56',
        'updated_at' => '2019-05-30 10:41:56',
    ],
];
