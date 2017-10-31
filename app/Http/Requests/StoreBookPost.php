<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookPost extends FormRequest
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
            'title' => 'required|unique:books',
            'author' => 'required',
            'published_at' => 'required|date',
            'press' => 'required',
            'type' => 'required',
            'category_id' => 'required|integer',
            'keywords' => 'required',
            'money' => 'required|integer',
            'logistics' => 'required',
            'freight' => 'required|integer',
            'cover' => 'required',
            'images.*' => 'required',
            'body' => 'required',
            'annex' => 'sometimes|required',
        ];
    }
}
