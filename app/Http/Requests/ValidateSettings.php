<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateSettings extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'training_days' => 'required|min:1|max:7',
            'first_day'     => 'required|in:1,2,3,4,5,6,7',
            'key'           => 'required|exists:users,key'
        ];
    }
}
