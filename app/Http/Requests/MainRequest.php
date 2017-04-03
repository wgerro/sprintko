<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainRequest extends FormRequest
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
                    'name'=>'required|unique:pages',
                    'slug'=>'required|unique:pages',
                ];
            break;

            case 'PUT':
            
                return [
                    'name'=>'required|unique:pages,name,'.$this->get('id'),
                    'slug'=>'required|unique:pages,slug,'.$this->get('id'),
                ]
            break;
        }
    }
}
