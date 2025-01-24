<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Models\Player;

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

        $players = Player::all();

        return response($players, 200);
    }
}
