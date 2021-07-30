<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateWorkoutSettings extends FormRequest
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
            'training_rest'   => 'required|min:5|max:45',
            'countdown_time'  => 'required|min:5|max:45',
            'metric_imperial' => 'required|in:metric,imperial',
            'key'             => 'required|exists:users,key'
        ];
    }
}
