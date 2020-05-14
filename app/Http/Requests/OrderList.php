<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderList extends FormRequest
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
            'dateBegin' => 'date_format:Y-m-d|nullable',
            'dateEnd' => 'date_format:Y-m-d|nullable',
        ];
    }
}
