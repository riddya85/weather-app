<?php

namespace App\Http\Requests\Front;

use App\Http\Requests\Request;

class ForecastRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()  {
//	    return \Gate::allows('save',$this->model());
	    return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()   {
	    return [
		    'lng'=> "required",
		    'lat'=> "sometimes"
	    ];
    }


	public function process(){

		$data = $this->all();
		
	}
}
