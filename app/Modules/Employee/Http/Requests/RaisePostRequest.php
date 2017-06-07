<?php

namespace App\Modules\Employee\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;

class RaisePostRequest extends FormRequest
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
            'f_name' => 'required|max:15',
            'l_name' => 'required|max:15',
            'email' => 'required|email|max:255',
           // 'password' => 'required|confirmed|min:6',
            
            ];
        }
        if (Request::isMethod('post')) {
            return [
            'effective_date' => 'required',
            'old_pay' => 'required',
            'new_pay' => 'required',
           
            //
            ];
        }
    }

    public function messages()
    {
        return [
        'effective_date.required' => 'Effective date is required',
        'old_pay.required'  => 'Old pay is required',
        'new_pay.required'  => 'New pay is required',
        ];
    }
}
