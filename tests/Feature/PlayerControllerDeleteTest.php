<?php

// /////////////////////////////////////////////////////////////////////////////
// TESTING AREA
// THIS IS AN AREA WHERE YOU CAN TEST YOUR WORK AND WRITE YOUR TESTS
// /////////////////////////////////////////////////////////////////////////////

namespace Tests\Feature;

use App\Models\Player;

class PlayerControllerDeleteTest extends PlayerControllerBaseTest
{
    public function test_unauthorized_cannot_delete()
    {
        $res = $this->delete(self::REQ_URI.'1', [], [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ]);

        $res->assertStatus(401);
    }

    public function test_unknown_token_fails()
    {
        $token = 'xxxxxxxxxxxxxxxxxxxx';

        $res = $this->delete(self::REQ_URI.'1', [], [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token,
        ]);

        $res->assertStatus(401);
    }

    public function test_authorized_can_delete()
    {
        Player::insert(['name' => 'test', 'position' => 'attack']);

        $token = 'SkFabTZibXE1aE14ckpQUUxHc2dnQ2RzdlFRTTM2NFE2cGI4d3RQNjZmdEFITmdBQkE=';

        $res = $this->delete(self::REQ_URI.'1', [], [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token,
        ]);

        $res->assertStatus(200);
    }
}
