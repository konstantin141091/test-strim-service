<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StreamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user()) {
            return true;
        }else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:256', 'min:4'],
            'description' => ['required', 'string', 'max:1000', 'min:10'],
            'preview' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:5120']
        ];
    }
}
