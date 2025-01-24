<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;

class TeamControllerTest extends PlayerControllerBaseTest
{
    public function test_sample()
    {
        $input = '
            [
                {
                    "position": "midfielder",
                    "mainSkill": "speed",
                    "numberOfPlayers": 5
                },
                {
                    "position": "defender",
                    "mainSkill": "strength",
                    "numberOfPlayers": 1
                }
            ]
        ';

        $json = json_decode($input, true);

        $res = $this->postJson(self::REQ_TEAM_URI, $json);

        $res->assertStatus(200);
    }

    public function test_duplicated_position_plus_skill_is_invalid()
    {
        $input = '
            [
                {
                    "position": "midfielder",
                    "mainSkill": "speed",
                    "numberOfPlayers": 5
                },
                {
                    "position": "midfielder",
                    "mainSkill": "speed",
                    "numberOfPlayers": 5
                }
            ]
        ';

        $json = json_decode($input, true);

        $res = $this->postJson(self::REQ_TEAM_URI, $json);

        $res->assertStatus(400);
    }
}
