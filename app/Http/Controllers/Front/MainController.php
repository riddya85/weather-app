<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ForecastRequest;
use App\Models\History;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('front.home');
    }

    public function prepareForecast(ForecastRequest $request)
    {
        $lat = $request->get('lat');
        $lng = $request->get('lng');

        $url = "https://api.darksky.net/forecast/".config('weatherForecast.APP_KEY')."/".$lat.",".$lng;

        $city = $request->get('name');

        $request->saveHistory();

        $info = file_get_contents($url);
        $info = json_decode($info);

        $currentForecast = $info->currently;

        $hourlyForecast = $info->hourly;

        $dailyForecast = $info->daily;

        return view('front.forecast',compact('currentForecast','hourlyForecast','dailyForecast','city'));
    }

    public function history() {
        $items = History::take(10)->orderBy('id','DESC')->get();

        return view('front.history',compact('items'));
    }

    public function userHistory() {
        if (Auth::check()) {
            $user = Auth::user();
            $items = History::where('user_id',$user->id)->orderBy('id','DESC')->limit(2)->get();

            return view('front.userHistory',compact('user','items'));
        } else {
            return redirect('/');
        }
    }
    
    public function adminUserHistory(User $user) {
        $user = Auth::user();
        
        if ($user->role == User::ROLE_ADMIN) {
            $items = History::where('user_id',$user->id)->orderBy('id','DESC')->limit(2)->get();

            return view('front.userHistory',compact('user','items'));
        } else {
            return redirect('/');
        }
    }

    public function loadUserHistory(Request $request) {
        $items = History::where('id','<',$request->get('lastId'))->where('user_id',Auth::user()->id)->orderBy('id','DESC')->limit(2)->get();
        $response = array();
        
        if(count($items)) {
            foreach ($items as $key => $item) {
                $response['items'][] = array('link'=>route('front.prepareForecast',array('lng'=>$item->lng,'lat'=>$item->lat,'name'=>$item->name)),'name'=>$item->name);
                if ($key == count($items)-1) $response['lastId'] = $item->id;
            }
        }

        return response()->json($response);
    }
}
