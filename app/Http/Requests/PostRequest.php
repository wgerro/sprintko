<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
        switch($this->method())
        {
            case 'POST':
                return [
                    'subject' => 'required|unique:posts',
                    'image'   => 'mimes:jpeg,png,jpg|max:500'
                ];
            break;

            case 'PUT':
                return [
                    'subject' => 'required|unique:posts,subject,'.$this->get('id'),
                    'image'   => 'mimes:jpeg,png,jpg|max:500'
                ];
            break;
        }
        
    }
}
