<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromoRequest extends FormRequest
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
            'promo-date-payment' => 'date_format:"d.m.Y"|nullable',
            'promo-quantity-payment' => 'numeric|nullable',
            'promo-cost-payment' => 'regex:/[0-9]+[.,]?[0-9]*/|nullable',
            //'promo-paid' => '',
            //'promo-company' => 'numeric',
            'promo-company-date-begin' => 'date_format:"d.m.Y"|nullable',
            'promo-company-date-end' => 'date_format:"d.m.Y"|nullable',
        ];
    }
}
