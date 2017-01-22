<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ForecastRequest;
use App\Models\History;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

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

        $timeLabels = array();
        $dataSet = array();
        $temperatures = array();
        $feelsLikeTemp = array();

        foreach ($hourlyForecast->data as $key => $item) {
            if ($key != 24) {
                $timeLabels[] = date('H:i',$item->time);

                $temperatures[] = number_format(($item->temperature-32)*5/9,1);
                $feelsLikeTemp[] = number_format(($item->apparentTemperature-32)*5/9,1);
            } else {
                break;
            }
        }

        $dataSet[] = array('label'=>'Temparature','data'=>array($temperatures),'backgroundColor'=>'rgba(153,255,51,0.4)');
        $dataSet[] = array('label'=>'Feels like','data'=>array($feelsLikeTemp),'backgroundColor'=>'rgba(255,153,0,0.4)');

        $chartData = json_encode(array('data'=>$dataSet,'labels'=>$timeLabels));

        return view('front.forecast',compact('currentForecast','hourlyForecast','dailyForecast','city','chartData'));
    }

    public function history() {
        $items = History::take(1)->orderBy('id','DESC')->get();

        return view('front.history',compact('items'));
    }

    public function userHistory() {
        if (Auth::check()) {
            $user = Auth::user();
            $items = History::where('user_id',$user->id)->orderBy('id','DESC')->limit(5)->get();

            return view('front.userHistory',compact('user','items'));
        } else {
            return redirect('/');
        }
    }
    
    public function adminUserHistory(User $user) {
        if (Auth::user()->role == User::ROLE_ADMIN) {
            $items = History::where('user_id',$user->id)->orderBy('id','DESC')->limit(5)->get();
            return view('front.userHistory',compact('user','items'));
        } else {
            return redirect('/');
        }
    }

    public function loadHistory(Request $request) {
        $user = $request->get('user');

        if ($user) {
            if ($user < 0) {
                $items = History::where('id','<',$request->get('lastId'))->where('user_id',Auth::user()->id)->orderBy('id','DESC')->limit(1)->get();
            } else {
                $items = History::where('id','<',$request->get('lastId'))->where('user_id',$user)->orderBy('id','DESC')->limit(1)->get();
            }
        } else {
            $items = History::where('id','<',$request->get('lastId'))->orderBy('id','DESC')->limit(1)->get();
        }

        return response()->json([
            'template' => View::make('front.partials.historyLink')->with('items',$items)->render()
        ]);
    }
}
