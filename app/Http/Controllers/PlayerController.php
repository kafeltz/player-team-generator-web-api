<?php

// /////////////////////////////////////////////////////////////////////////////
// PLEASE DO NOT RENAME OR REMOVE ANY OF THE CODE BELOW.
// YOU CAN ADD YOUR CODE TO THIS FILE TO EXTEND THE FEATURES TO USE THEM IN YOUR WORK.
// /////////////////////////////////////////////////////////////////////////////

namespace App\Http\Controllers;

use App\Http\Requests\PlayerRequest;
use App\Http\Resources\PlayerResource;
use App\Models\Player;
use App\Models\PlayerSkill;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{
    public function index()
    {
        return response('Failed', 500);
    }

    public function show()
    {
        return response('Failed', 500);
    }

    public function store(PlayerRequest $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();

            $player = new Player([
                'name' => $validated['name'],
                'position' => $validated['position'],
            ]);

            $player->save();

            $data = collect($validated['playerSkills'])->map(function ($item) use ($player) {
                $arrayToMerge = [
                    'player_id' => $player->id,
                ];

                return array_merge($item, $arrayToMerge);

            })->toArray();

            PlayerSkill::insert($data);

            DB::commit();

            $player = Player::find($player->id); // reload with full associated objects.
            $playerResource = new PlayerResource($player);

            return response()->json($playerResource, 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'An error occurred: '.$e->getMessage()], 500);
        }

    }

    public function update()
    {
        return response('Failed', 500);
    }

    public function destroy()
    {
        return response('Failed', 500);
    }
}
