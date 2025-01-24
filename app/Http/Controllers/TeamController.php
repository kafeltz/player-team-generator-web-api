<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Models\Player;
use Exception;

class TeamController extends Controller
{
    public function process(TeamRequest $request)
    {
        // [
        //     {
        //        "position": "midfielder",
        //        "mainSkill": "speed",
        //        "numberOfPlayers": 5
        //     },
        //     {
        //        "position": "defender",
        //         "mainSkill": "strength",
        //         "numberOfPlayers": 1
        //     }
        // ]
        $data = $request->all();

        // rules
        // 1: cannot be sent a request with a position with duplicated skill
        self::checkDuplicatedSkillAndThrows($request);

        $players = Player::all();

        return response($players, 200);
    }

    private function checkDuplicatedSkillAndThrows(TeamRequest $request)
    {
        $data = $request->all();

        $map = [];
        foreach ($data as $value) {
            $key = $value['position'].$value['mainSkill'];

            if (! array_key_exists($key, $map)) {
                $map[$key] = 1;
            } else {
                $map[$key]++;
            }

            if ($map[$key] > 1) {
                throw new Exception('It cannot accept duplicated skill with the same position');
            }
        }
    }
}
