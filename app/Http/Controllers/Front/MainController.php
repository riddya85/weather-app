<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ForecastRequest;
use App\Models\History;
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

    public function prepareForecast(ForecastRequest $request,$lng, $lat)
    {
        $url = "https://api.darksky.net/forecast/".config('weatherForecast.APP_KEY')."/".$lat.",".$lng;

        $city = $request->get('name');

//        if (!is_null($item = History::where('lng',$lng)->where('lat',$lat)->first())) {
//            $city = $item->name;
//        }
//
//        $request->saveHistory();

        $info = file_get_contents($url);
        $info = json_decode($info);

        $currentForecast = $info->currently;

        $hourlyForecast = $info->hourly;

        $dailyForecast = $info->daily;

        return view('front.forecast',compact('currentForecast','hourlyForecast','dailyForecast','city'));
    }

//    public function history() {
//        $items = History::take(10)->orderBy('id','DESC')->get();
//
//        return view('front.history',compact('items'));
//    }
}
