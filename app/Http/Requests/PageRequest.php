<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
                    'slug'=>'required|unique:pages'
                ];
            break;

            case 'PUT':
                if($this->get('id') != 1)
                {
                    return [
                        'name'=>'required|unique:pages,name,'.$this->get('id'),
                        'slug'=>'required|unique:pages,slug,'.$this->get('id')
                    ];
                }
                else{
                    return [
                        'name'=>'required|unique:pages,name,'.$this->get('id'),
                    ];
                }
            break;
        }
    }
}
