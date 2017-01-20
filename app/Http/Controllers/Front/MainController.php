<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ForecastRequest;
use Illuminate\Http\Request;

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

    public function prepareForecast(Request $request,$lng, $lat)
    {
        $url = "https://api.darksky.net/forecast/d0404c2ee1c64b28969ddde9dc098d88/".$lat.",".$lng;

        $city = $request->get('city');

        $info = file_get_contents($url);

        $info = json_decode($info);

        $currentForecast = $info->currently;

        $hourlyForecast = $info->hourly;

        $dailyForecast = $info->daily;

        return view('front.forecast',compact('currentForecast','hourlyForecast','dailyForecast','city'));
    }
}
