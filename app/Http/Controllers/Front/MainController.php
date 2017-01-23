<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ForecastRequest;
use App\Models\History;
use App\Models\User;
use App\Services\WeatherService;
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
        $weatherService = new WeatherService(config('weatherForecast.APP_KEY'));

        $city = $request->get('name');

        $info = $weatherService->getData($request->get('lat'),$request->get('lng'));

        $request->saveHistory();

        $currentForecast = $info['currentForecast'];

        $hourlyForecast = $info['hourlyForecast'];

        $dailyForecast = $info['dailyForecast'];

        $summary = $info['summary'];

        $chartData = $weatherService->prepareChartData($hourlyForecast);

        return view('front.forecast',compact('currentForecast','hourlyForecast','dailyForecast','city','chartData','summary'));
    }

    public function history() {
        $history = new History();
        $items = $history->getItems();


        return view('front.history',compact('items'));
    }

    public function userHistory() {
        if (Auth::check()) {
            $history = new History();
            $user = Auth::user();
            $items = $history->getUserItems($user->id);

            return view('front.userHistory',compact('user','items'));
        } else {
            return redirect('/');
        }
    }
    
    public function adminUserHistory(User $user) {
        if (Auth::user()->role == User::ROLE_ADMIN) {
            $history = new History();
            $items = $history->getUserItems($user->id);

            return view('front.userHistory',compact('user','items'));
        } else {
            return redirect('/');
        }
    }

    public function loadHistory(Request $request) {
        $user = $request->get('user');
        $history = new History();
        $lastId = $request->get('lastId');

        if ($user) {
            if ($user < 0) {
                $items = $history->getMoreUserItems(Auth::user()->id,$lastId);
            } else {
                $items = $history->getMoreUserItems($user,$lastId);
            }
        } else {
            $items = $history->getMoreItems($lastId);
        }

        return response()->json([
            'template' => View::make('front.partials.historyLink')->with('items',$items)->render()
        ]);
    }
}
