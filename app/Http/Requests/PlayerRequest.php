<?php

namespace App\Http\Requests;

use App\Enums\PlayerPosition;
use App\Enums\PlayerSkill;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class PlayerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'position' => ['required', new Enum(PlayerPosition::class)], // laravel 9+ style
            'playerSkills' => 'required|array',
            'playerSkills.*.skill' => ['required',
                function ($attribute, $value, $fail) {
                    $toArray = PlayerSkill::toArray();
                    if (! in_array($value, $toArray)) {
                        $fail("Invalid value for $attribute: $value");
                    }
                }, ],
            'playerSkills.*.value' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name field is mandatory!',
            'position' => 'Invalid value for :attribute: '.$this->position,
            'position.required' => 'Position value is mandatory',
        ];
    }
}
