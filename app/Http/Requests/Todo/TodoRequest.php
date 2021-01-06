<?php

namespace App\Http\Requests\Todo;

use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
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
        
		switch ($this->method()) {
			case 'GET':{
				return[
				];
			}
			case 'DELETE': {
				return [
                ];
			}
			case 'POST': {
				return [
                    'name' => 'required|max:255',
				];
			}
			case 'PUT':
			case 'PATCH': {
				return [

                ];
			}
			default:
				break;
		}
    }
    
    public function messages()
	{
		return [
           'user_id.required' => 'User Id is required',
           'user_id.exists' => 'Invalid user Id'
		];
	}
}
