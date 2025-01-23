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
    public function test_empty_object()
    {
        $data = []; // empty
        $res = $this->postJson(self::REQ_URI, $data);
        $res->assertStatus(422);
        $json = $res->decodeResponseJson();

        $this->assertEquals('Name field is mandatory!', $json['errors']['name'][0]);
        $this->assertEquals('Position value is mandatory', $json['errors']['position'][0]);
        $this->assertEquals('The player skills field is required.', $json['errors']['playerSkills'][0]);
    }

    public function test_PlayerRequestMustBeValidccc()
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
    }

    public function test_valid_object()
    {
        // finally: valid request always works
        $data = [
            'name' => 'Valid value!',
            'position' => PlayerPosition::FORWARD,
            'playerSkills' => [
                0 => [
                    'skill' => PlayerSkill::ATTACK,
                    'value' => '60',
                ],
            ],
        ];
        $res = $this->postJson(self::REQ_URI, $data);

        $res->assertStatus(200);
    }
}
