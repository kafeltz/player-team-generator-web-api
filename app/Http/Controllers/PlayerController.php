<?php

// /////////////////////////////////////////////////////////////////////////////
// PLEASE DO NOT RENAME OR REMOVE ANY OF THE CODE BELOW.
// YOU CAN ADD YOUR CODE TO THIS FILE TO EXTEND THE FEATURES TO USE THEM IN YOUR WORK.
// /////////////////////////////////////////////////////////////////////////////

namespace App\Http\Controllers;

use App\Http\Requests\PlayerRequest;

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
        return response('Failed', 200);
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
