<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContentRequest extends FormRequest
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
                $table = array('name'=>'required|unique:contents');
            break;

            case 'PUT':
                $table = array('name'=>'required|unique:contents,name,'.$this->get('id'));
            break;
        }
        return $table;
    }
}
