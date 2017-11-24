<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookPost extends FormRequest
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
            'title' => 'sometimes|required|unique:books',
            'author' => 'sometimes|required',
            'published_at' => 'sometimes|required|date',
            'press' => 'sometimes|required',
            'type' => 'sometimes|required',
            'category_id' => 'sometimes|required|integer',
            'keywords' => 'sometimes|required',
            'money' => 'sometimes|required|integer',
            'logistics' => 'sometimes|required',
            'freight' => 'sometimes|required|integer',
            'cover' => 'sometimes|required',
            'images.*' => 'sometimes|required',
            'body' => 'sometimes|required',
            'annex' => 'sometimes|required',
        ];
    }
}
