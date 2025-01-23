<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;

class PlayerControllerUpdateTest extends PlayerControllerBaseTest
{
    public function test_sample()
    {
        $data = [
            'name' => 'test',
            'position' => 'defender',
            'playerSkills' => [
                0 => [
                    'skill' => 'attack',
                    'value' => 60,
                ],
                1 => [
                    'skill' => 'speed',
                    'value' => 80,
                ],
            ],
        ];

        $res = $this->putJson(self::REQ_URI.'1', $data);

        $this->assertNotNull($res);
    }

    public function test_empty_object_must_fail()
    {
        $data = []; // empty
        $res = $this->putJson(self::REQ_URI.'1', $data);
        $res->assertStatus(422);
        $json = $res->decodeResponseJson();

        $this->assertEquals('Name field is mandatory!', $json['errors']['name'][0]);
        $this->assertEquals('Position value is mandatory', $json['errors']['position'][0]);
        $this->assertEquals('The player skills field is required.', $json['errors']['playerSkills'][0]);
    }

    public function test_update_player()
    {
        $input = '
            {
                "name": "player name updated",
                "position": "midfielder",
                "playerSkills": [
                    {
                        "skill": "strength",
                        "value": 40
                    },
                    {
                        "skill": "stamina",
                        "value": 30
                    }
                ]
            }
        ';

        $json = json_decode($input, true);

        $res = $this->postJson(self::REQ_URI, $json);

        $res->assertStatus(200);

        $res->assertJson(['name' => 'player name updated', 'position' => 'midfielder', 'playerSkills' => [
            [
                'id' => 1,
                'skill' => 'strength',
                'value' => 40,
                'player_id' => 1,
            ], [
                'id' => 2,
                'skill' => 'stamina',
                'value' => 30,
                'player_id' => 1,
            ],
        ],
        ]);
    }
}
