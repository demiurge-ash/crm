<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleForm extends FormRequest
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
            'user_id'       => 'required|numeric',
            'time_begin'    => 'required|date_format:"H:i"',
            'time_end'      => 'required|date_format:"H:i"',
            'date'          => 'required|date_format:"Y-m-d"',
        ];
    }
}
