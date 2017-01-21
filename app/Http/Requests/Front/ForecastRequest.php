<?php

namespace App\Http\Requests\Front;

use App\Http\Requests\Request;
use App\Models\History;
use Illuminate\Support\Facades\Auth;

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
		    'lat'=> "required",
			'name' => 'required'
	    ];
    }

	public function data(){
		return $this->only(['lng','lat','name']);
	}


	public function saveHistory() {

		$history = new History($this->data());

		if (Auth::check()) {
			$history->user()->associate(Auth::user());
		} else {
			$history->user_id = NULL;
		}

		$history->save();
	}

}
