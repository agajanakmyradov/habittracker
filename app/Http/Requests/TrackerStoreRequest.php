<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrackerStoreRequest extends FormRequest
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
        $rules =  [
            'title' => ['required', 'max:255'],
            'last_day' => ['required'],
        ];
        $all = $this->all();

        if ($all['period_type'] == 'days') {            
            $rules['days'] = ['required'];
        } elseif ($all['period_type'] == 'weekday') {
            $rules['weekday'] = ['required'];
        }

        return $rules;
    }
}