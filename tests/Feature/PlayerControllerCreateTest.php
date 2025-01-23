<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;

use App\Enums\PlayerPosition;
use App\Enums\PlayerSkill;

class PlayerControllerCreateTest extends PlayerControllerBaseTest
{
    public function test_empty_object_must_fail()
    {
        $data = []; // empty
        $res = $this->postJson(self::REQ_URI, $data);
        $res->assertStatus(422);
        $json = $res->decodeResponseJson();

        $this->assertEquals('Name field is mandatory!', $json['errors']['name'][0]);
        $this->assertEquals('Position value is mandatory', $json['errors']['position'][0]);
        $this->assertEquals('The player skills field is required.', $json['errors']['playerSkills'][0]);
    }

    public function test_PlayerRequestPartialValid_must_fail()
    {
        $data = [
            'name' => 'Valid!', // empty!
            'position' => PlayerPosition::DEFENDER,
            'playerSkills' => [],
        ];

        $res = $this->postJson(self::REQ_URI, $data);
        $res->assertStatus(422);
    }

    public function test_valid_object_must_succeed()
    {
        // finally: valid request always works
        $data = [
            'name' => 'Valid value!',
            'position' => PlayerPosition::FORWARD,
            'playerSkills' => [
                0 => [
                    'skill' => PlayerSkill::ATTACK,
                    'value' => '60', // number in string format
                ],
                1 => [
                    'skill' => PlayerSkill::STRENGTH,
                    'value' => 60, // number
                ],
            ],
        ];
        $res = $this->postJson(self::REQ_URI, $data);

        $res->assertStatus(200);
    }

    public function test_create_player()
    {
        $input = '
            {
                "name": "player name 2",
                "position": "midfielder",
                "playerSkills": [
                    {
                        "skill": "attack",
                        "value": 60
                    },
                    {
                        "skill": "speed",
                        "value": 80
                    }
                ]
            }
        ';

        $json = json_decode($input, true);

        $res = $this->postJson(self::REQ_URI, $json);

        $res->assertStatus(200);

        $res->assertJson(['name' => 'player name 2', 'position' => 'midfielder', 'playerSkills' => [
            [
                'id' => 1,
                'skill' => 'attack',
                'value' => 60,
                'player_id' => 1,
            ], [
                'id' => 2,
                'skill' => 'speed',
                'value' => 80,
                'player_id' => 1,
            ],
        ],
        ]);
    }
}
