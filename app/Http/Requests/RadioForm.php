<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RadioForm extends FormRequest
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
            'radio-date-begin' => 'required|date_format:"d.m.Y"',
            'radio-date-end' => 'date_format:"d.m.Y"|nullable',
            'radio-quantity' => 'numeric|nullable',
            'radio-duration' => 'numeric|nullable',
            'radio-placement-paid' => '',
            'radio-price' => 'regex:/[0-9]+[.,]?[0-9]*/|nullable',
            'radio-sale' => 'regex:/[0-9]+[.,]?[0-9]*/|nullable',
            'radio-text' => '',
            'radio-file' => 'file|mimetypes:audio/mp3,application/octet-stream,audio/mpeg',
        ];
    }
}
