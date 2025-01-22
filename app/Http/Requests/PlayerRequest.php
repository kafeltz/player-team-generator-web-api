<?php

namespace App\Http\Requests;

use App\Enums\PlayerPosition;
use App\Enums\PlayerSkill;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Validator;

class PlayerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'position' => ['required', new Enum(PlayerPosition::class)], // laravel 9+ style
            'playerSkills' => 'array',
            'playerSkills.*.skill' => ['required', new Enum(PlayerSkill::class)],
            'playerSkills.*.value' => 'required|numeric|gt:0',
        ];
    }

    public function messages(): array
    {
        // $validValues = [];
        // foreach (PlayerPosition::cases() as $value) {
        //     $validValues[] = $value->name;
        // }

        return [
            'name.required' => 'Name field is mandatory!',
            'position' => 'Invalid value for :attribute: '.$this->position,
            'position.required' => 'Position value is mandatory',
            'playerSkills.*.skill' => 'Invalid value for :attribute: ',
        ];
    }

    // public function after(): array
    // {
    //     return [
    //         function (Validator $validator) {
    //             $validator->errors()->add(
    //                 'position',
    //                 'Invalid value for position: midfielder1'
    //             );
    //         },
    //     ];
    // }
}
