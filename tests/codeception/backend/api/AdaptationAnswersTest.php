<?php

namespace codeception\backend\api;

use Codeception\Util\HttpCode;
use tests\codeception\backend\unit\TestCase;
use tests\codeception\common\fixtures\AdaptationAnswersFixture;
use tests\codeception\common\fixtures\AdaptationFixture;
use tests\codeception\common\fixtures\AuthAssignmentFixture;
use tests\codeception\common\fixtures\UserFixture;
use tests\codeception\components\Collection;

class AdaptationAnswersTest extends TestCase
{
    protected $tester;

    public function fixtures()
    {
        return [
            'adaptation' => AdaptationFixture::class,
            'auth_assignment' => AuthAssignmentFixture::class,
            'user' => UserFixture::class,
            'adaptation_answers' => AdaptationAnswersFixture::class,
        ];
    }

    public function testView()
    {
        $I = $this->tester;
        $I->sendGET('rest/adaptation-answers');
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
        $I->amHttpAuthenticated(Collection::ADMIN_EMAIL, Collection::ADMIN_PASS);
        $I->sendGET('rest/adaptation-answers');
        $I->seeResponseContainsJson([
            [
                'uid' => '076e2b2e-a0eb-4259-a2a9-d4da78dc9248',
                'adaptation_uid' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23ff',
                'username' => 'Homylev Alexander',
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
                ],
                'device_id' => 1,
                'files_status' => 'none',
                'created_at' => '2019-04-21 09:25:37',
                'answer_at' => '2020-04-21 09:25:37',
            ],
            [
                'uid' => 'a78fdcfa-bf49-4412-9db2-8168b6b283e8',
                'adaptation_uid' => 'ac0da11b-a5df-40cb-96bf-23716e066dd9',
                'username' => 'Arabar Baratov',
                'answers' => [
                    [
                        'id'=> '649a9c4c-1b4b-46c9-932d-8a50f3ee23da',
                        'type'=> 1,
                        'comment'=> 'Всё отлично!',
                        'answer'=> 10
                    ],
                    [
                        'id'=> '649a9c4c-1b4b-46c9-932d-8a50f3ee23db',
                        'type'=> 2,
                        'answer'=> 35
                    ],
                    [
                        'id'=> '649a9c4c-1b4b-46c9-932d-8a50f3ee23dc',
                        'type'=> 5,
                        'comment'=> 'Интересный вопрос',
                        'answer'=> [
                            '1'
                        ]
                    ]
                ],
                'device_id' => 2,
                'files_status' => 'none',
                'created_at' => '2019-04-21 09:25:37',
                'answer_at' => '2020-04-21 09:25:37',
            ],
            [
                'uid' => 'b42afd0a-01ef-4787-848d-160894d8e7cb',
                'adaptation_uid' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23ff',
                'username' => 'Papa Jons',
                'device_id' => 3,
                'answers' => [],
                'files_status' => 'none',
                'created_at' => '2019-04-21 09:25:37',
                'answer_at' => null,
            ],
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function testViewByUid() {
        $I = $this->tester;
        $I->amHttpAuthenticated(Collection::ADMIN_EMAIL, Collection::ADMIN_PASS);
        $I->sendGET('rest/adaptation-answers/076e2b2e-a0eb-4259-a2a9-d4da78dc9248');
        $I->seeResponseContainsJson([
            'uid' => '076e2b2e-a0eb-4259-a2a9-d4da78dc9248',
            'adaptation_uid' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23ff',
            'username' => 'Homylev Alexander',
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
            ],
            'device_id' => 1,
            'created_at' => '2019-04-21 09:25:37',
            'answer_at' => '2020-04-21 09:25:37',
            'open_at' => '2020-04-21 09:25:37',
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function testViewByFillters() {
        $I = $this->tester;
        $I->amHttpAuthenticated(Collection::ADMIN_EMAIL, Collection::ADMIN_PASS);
        $I->sendGET('rest/adaptation-answers?is_processed=0&is_filled=0');
        $I->seeResponseContainsJson([
            [
                'uid' => '1df00090-29ec-4e1c-a259-a1fa8368c5f8',
                'adaptation_uid' => 'f9ddc6f3-4bdc-45a9-a26d-df79e385de01',
                'username' => 'Kalina Mashina',
                'is_processed' => false,
                'answers' => [],
                'device_id' => 54,
                'files_status' => 'attached',
                'created_at' => '2019-04-21 09:25:37',
                'answer_at' => null,
                'open_at' => '2019-04-21 09:25:37',
            ],
            [
                'uid' => 'b42afd0a-01ef-4787-848d-160894d8e7cb',
                'adaptation_uid' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23ff',
                'username' => 'Papa Jons',
                'is_processed' => false,
                'device_id' => 3,
                'answers' => [],
                'files_status' => 'none',
                'created_at' => '2019-04-21 09:25:37',
                'answer_at' => null,
                'open_at' => '2019-04-21 09:25:37',
            ],
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function testCreate()
    {
        $I = $this->tester;
        $I->amHttpAuthenticated(Collection::ADMIN_EMAIL, Collection::ADMIN_PASS);
        $I->sendPost('rest/adaptation-answers', [
            'uid' => '33e2b734-6e27-49da-868c-a01455a86e07',
            'adaptation_uid' => 'ac0da11b-a5df-40cb-96bf-23716e066dd9',
            'username' => 'Gabe Logan',
            'answers' => [
                    [
                        'id'=> '649a9c4c-1b4b-46c9-932d-8a50f3ee23da',
                        'type'=> 1,
                        'comment'=> 'Всё отлично!',
                        'answer'=> 10
                    ],
                    [
                        'id'=> '649a9c4c-1b4b-46c9-932d-8a50f3ee23db',
                        'type'=> 2,
                        'answer'=> 35
                    ],
                    [
                        'id'=> '649a9c4c-1b4b-46c9-932d-8a50f3ee23dc',
                        'type'=> 5,
                        'comment'=> 'Интересный вопрос',
                        'answer'=> [
                            '1'
                        ]
                    ]
                ],
                'device_id' => 14,
                'open_at' => null
        ]);

        $I->seeResponseContainsJson([
                'uid' => '33e2b734-6e27-49da-868c-a01455a86e07',
                'adaptation_uid' => 'ac0da11b-a5df-40cb-96bf-23716e066dd9',
                'username' => 'Gabe Logan',
                'answers' => [
                    [
                        'id'=> '649a9c4c-1b4b-46c9-932d-8a50f3ee23da',
                        'type'=> 1,
                        'comment'=> 'Всё отлично!',
                        'answer'=> 10
                    ],
                    [
                        'id'=> '649a9c4c-1b4b-46c9-932d-8a50f3ee23db',
                        'type'=> 2,
                        'answer'=> 35,
                        'comment'=> null,
                    ],
                    [
                        'id'=> '649a9c4c-1b4b-46c9-932d-8a50f3ee23dc',
                        'type'=> 5,
                        'comment'=> 'Интересный вопрос',
                        'answer'=> [
                            '1'
                        ]
                    ]
                ],
                'device_id' => 14,
                'open_at' => null,
                'is_processed' => null,
                'files_status' => 'unknown',
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
    }

    public function testUpdate()
    {
        $I = $this->tester;
        $I->amHttpAuthenticated(Collection::ADMIN_EMAIL, Collection::ADMIN_PASS);
        $I->sendPUT('rest/adaptation-answers/076e2b2e-a0eb-4259-a2a9-d4da78dc9248', [
            'username' => 'Homylev Gnomylev',
            'is_processed'=> true,
            'answers' => [
                [
                    'id'=> '649a9c4c-1b4b-46c9-932d-8a50f3ee23da',
                    'type'=> 1,
                    'comment'=> 'How i can do it?',
                    'answer'=> 33
                ]
            ]
        ]);
        $I->seeResponseContainsJson([
            'uid' => '076e2b2e-a0eb-4259-a2a9-d4da78dc9248',
            'adaptation_uid' => '649a9c4c-1b4b-46c9-932d-8a50f3ee23ff',
            'username' => 'Homylev Gnomylev',
            'answers' => [
                [
                    'id'=> '649a9c4c-1b4b-46c9-932d-8a50f3ee23da',
                    'type'=> 1,
                    'comment'=> 'How i can do it?',
                    'answer'=> 33
                ]
            ],
            'is_processed'=> '1',
            'device_id' => 1,
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function testCreateNullAnsewr()
    {
        $I = $this->tester;
        $I->amHttpAuthenticated(Collection::ADMIN_EMAIL, Collection::ADMIN_PASS);
        $I->sendPost('rest/adaptation-answers', [
            'uid' => '33e2b734-6e27-49da-868c-a01455a86e07',
            'adaptation_uid' => 'ac0da11b-a5df-40cb-96bf-23716e066dd9',
            'username' => 'Gabe Logan',
            'device_id' => 14,
        ]);
        $I->seeResponseContainsJson([
            'uid' => '33e2b734-6e27-49da-868c-a01455a86e07',
            'adaptation_uid' => 'ac0da11b-a5df-40cb-96bf-23716e066dd9',
            'username' => 'Gabe Logan',
            'answers' => [],
            'device_id' => 14,
            'is_processed' => null,
            'files_status' => 'unknown',
            'answer_at' => null
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
    }

    public function testDeleteFilled()
    {
        $I = $this->tester;
        $I->amHttpAuthenticated(Collection::ADMIN_EMAIL, Collection::ADMIN_PASS);
        $I->sendDelete('rest/adaptation-answers/a78fdcfa-bf49-4412-9db2-8168b6b283e8');
        $I->seeResponseContainsJson([
            'name' => 'Unprocessable entity',
            'message' => 'Unable to delete a completed Adaptation.'
        ]);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
    }

    public function testDelete()
    {
        $I = $this->tester;
        $I->amHttpAuthenticated(Collection::ADMIN_EMAIL, Collection::ADMIN_PASS);
        $I->sendDelete('rest/adaptation-answers/1df00090-29ec-4e1c-a259-a1fa8368c5f8');
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }
}
