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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{
    public function index()
    {
        $players = Player::all();

        $data = PlayerResource::collection($players);

        return response()->json($data, 200);
    }

    public function show(Request $request, int $id)
    {
        $player = Player::findOrFail($id);

        $data = new PlayerResource($player);

        return response()->json($data, 200);
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

    public function update(PlayerRequest $request, int $id)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();

            $player = Player::findOrFail($id);
            $player->name = $validated['name'];
            $player->position = $validated['position'];
            $player->save();

            PlayerSkill::where('player_id', $player->id)->delete();

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

    public function destroy(Request $request, int $id)
    {
        $token = $request->headers->get('authorization');

        if ($token != 'Bearer SkFabTZibXE1aE14ckpQUUxHc2dnQ2RzdlFRTTM2NFE2cGI4d3RQNjZmdEFITmdBQkE=') {
            return abort(401);
        }

        $player = Player::findOrFail($id);
        $player->delete();

        return response()->json(['id' => $id, 'deleted' => true], 200);
    }
}
