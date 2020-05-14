<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhotoRequest extends FormRequest
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
            'photo-date-payment' => 'date_format:"d.m.Y"|nullable',
            'photo-period' => 'numeric|nullable',
            'photo-cost' => 'regex:/[0-9]+[.,]?[0-9]*/|nullable',
//            'photo-paid' => '',
//            'photo-company' => 'numeric',
            'photo-company-date-begin' => 'date_format:"d.m.Y"|nullable',
            'photo-company-date-end' => 'date_format:"d.m.Y"|nullable',
        ];
    }
}
