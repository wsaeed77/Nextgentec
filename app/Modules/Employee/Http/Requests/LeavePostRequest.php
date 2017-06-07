<?php

namespace App\Modules\Employee\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;

class LeavePostRequest extends FormRequest
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
        //dd($this->request->isMethod('put'));
        if (Request::isMethod('put')) {
            /*if(!empty(Request::input('password')))
            {
                'password' => 'required|confirmed|min:6',
                
            }*/
            return [
            'start_date' => 'required',
            'end_date' => 'required',
            'type' => 'required',
           // 'password' => 'required|confirmed|min:6',
            
            ];
        }
        if (Request::isMethod('post')) {
            return [
            'start_date' => 'required',
            'title' => 'required|max:15',
            'end_date' => 'required',
            'type' => 'required',
           // 'password' => 'required|confirmed|min:6',
            
            ];
        }
    }

    public function messages()
    {
        return [
            'start_date.required' => 'Start date is required',
            'end_date.required'  => 'End date is required',
            'type.required'  => 'Leave type is required',
            
        ];
    }
}
