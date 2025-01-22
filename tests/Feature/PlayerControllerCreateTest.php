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
    // test if App\Http\Requests\PlayerRequest is correctly implemented
    public function test_PlayerRequestMustBeValid()
    {
        $data = [
            'name' => '', // empty!
            'position' => 'invalid value!',
            'playerSkills' => [
                0 => [
                    'skill' => 'invalid!',
                    'value' => 60,
                ],
            ],
        ];

        $res = $this->postJson(self::REQ_URI, $data);
        $res->assertStatus(422);

        // test completed empty object
        $data = [];
        $res = $this->postJson(self::REQ_URI, $data);
        $res->assertStatus(422);
        $json = $res->decodeResponseJson();
        $this->assertEquals('Name field is mandatory!', $json['errors']['name'][0]);
        $this->assertEquals('Position value is mandatory', $json['errors']['position'][0]);

        // test with invalid `position` attribute
        $data = [
            'name' => 'some valid name',
            'position' => 'INVALID!',
            'playerSkills' => [
                0 => [
                    'skill' => PlayerSkill::ATTACK,
                    'value' => 60,
                ],
            ], ];
        $res = $this->postJson(self::REQ_URI, $data);
        $res->assertStatus(422);
        $json = $res->decodeResponseJson();
        $this->assertEquals('Invalid value for position: INVALID!', $json['errors']['position'][0]);

        // test with invalid `skill` attribute
        $data = [
            'name' => 'some valid name',
            'position' => PlayerPosition::DEFENDER,
            'playerSkills' => [
                0 => [
                    'skill' => 'invalid skill value!',
                    'value' => 60,
                ],
            ]];
        $res = $this->postJson(self::REQ_URI, $data);
        $res->assertStatus(422);
        $json = $res->decodeResponseJson();
        dd($json);
        $this->assertEquals('Invalid value for position: INVALID!', $json['errors']['playerSkills'][0]);

        // finally: valid request always works
        $data = [
            'name' => 'Valid value!',
            'position' => PlayerPosition::DEFENDER,
            'playerSkills' => [
                0 => [
                    'skill' => PlayerSkill::ATTACK,
                    'value' => 60,
                ],
            ],
        ];
        $res = $this->postJson(self::REQ_URI, $data);
        $res->assertStatus(200);
    }

    public function test_sample()
    {
        $data = [
            'name' => 'test',
            'position' => 'defender',
            'playerSkills' => [
                0 => [
                    'skill' => PlayerSkill::ATTACK,
                    'value' => 60,
                ],
                1 => [
                    'skill' => 'speed',
                    'value' => 80,
                ],
            ],
        ];

        $res = $this->postJson(self::REQ_URI, $data);

        $res->assertStatus(200);

    }
}
