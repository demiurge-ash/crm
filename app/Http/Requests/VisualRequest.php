<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisualRequest extends FormRequest
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
            'visual-product' => 'numeric',
            'visual-designer' => 'numeric',

            'visual-design-width' => 'numeric|nullable',
            'visual-design-height' => 'numeric|nullable',
            'visual-design-size' => 'numeric',
            'visual-design-date-payment' => 'date_format:"d.m.Y"|nullable',
            'visual-design-total-price' => 'regex:/[0-9]+[.,]?[0-9]*/|nullable',
            'visual-design-file' => 'file|mimes:pdf,ai,psd,jpg,jpeg',

            'visual-production-contractor' => 'numeric',
            'visual-production-quantity' => 'numeric|nullable',
            'visual-production-price' => 'regex:/[0-9]+[.,]?[0-9]*/|nullable',
            'visual-production-sale' => 'regex:/[0-9]+[.,]?[0-9]*/|nullable',
            'visual-production-total-price' => 'regex:/[0-9]+[.,]?[0-9]*/|nullable',

            'visual-montage-type' => 'numeric',
            'visual-montage-date-begin' => 'date_format:"d.m.Y"|nullable',
            'visual-montage-date-end' => 'date_format:"d.m.Y"|nullable',
            'visual-montage-quantity' => 'numeric|nullable',
            'visual-montage-price' => 'regex:/[0-9]+[.,]?[0-9]*/|nullable',
            'visual-montage-sale' => 'regex:/[0-9]+[.,]?[0-9]*/|nullable',
            'visual-montage-manager' => 'numeric',
        ];
    }
}
