<?php

namespace App\Http\Requests;

use App\Enums\PlayerPosition;
use App\Enums\PlayerSkill;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class TeamRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // TODO: remove copy and paste from PLayerRequest, making one class only
        return [
            '*.position' => ['required', new Enum(PlayerPosition::class)], // laravel 9+ style
            '*.mainSkill' => ['required',
                function ($attribute, $value, $fail) {
                    $toArray = PlayerSkill::toArray();
                    if (! in_array($value, $toArray)) {
                        $fail("Invalid value for $attribute: $value");
                    }
                }, ],
            '*.numberOfPlayers' => 'required|integer|min:1',
        ];
    }
}
