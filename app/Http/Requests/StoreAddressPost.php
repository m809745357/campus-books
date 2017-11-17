<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressPost extends FormRequest
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
            'user_name' => 'sometimes|required',
            'tel_number' => 'sometimes|required',
            'province_name' => 'sometimes|required',
            'city_name' => 'sometimes|required',
            'country_name' => 'sometimes|required',
            'detail_info' => 'sometimes|required',
            'postal_code' => 'sometimes|required',
            'national_code' => 'sometimes|required',
        ];
    }
}
