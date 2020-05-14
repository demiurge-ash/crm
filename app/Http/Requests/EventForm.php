<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventForm extends FormRequest
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
            'date_begin' => 'date_format:"Y-m-d"|required',
            'date_end' => 'date_format:"Y-m-d"|required',
            'event' => 'numeric|required',
            'user' => 'numeric|required',
        ];
    }
}
