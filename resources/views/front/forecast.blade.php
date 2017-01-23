@extends('layout')
@section('javascript')
<script>
    app.chartData = {!! $chartData !!};
</script>
@endsection
@section('content')
    <div class="container forecast">
        <div class="row main">
            <h1>{{ $city }}</h1>
            <p>{{ date('Y-m-d H:i',$currentForecast->time) }}</p>
        </div>
        <div class="row">
            <h2>Current weather:</h2>
            @if($currentForecast->icon == 'rain')
                <img class="icon" src="http://www.iconarchive.com/download/i89288/icons8/ios7/Weather-Rain.ico"/>
            @elseif($currentForecast->icon == 'snow')
                <img class="icon" src="https://d30y9cdsu7xlg0.cloudfront.net/png/64-200.png"/>
            @else
                <img class="icon" src="https://www.colourbox.com/preview/5472017-weather-icon-sun-cloud.jpg"/>
            @endif
            <h3>Pressure: <span class="degree">{{ $currentForecast->pressure }} mb</span></h3>
            <h3>Humidity: <span class="degree">{{ $currentForecast->humidity }}%</span></h3>
            <h3>Wind speed: <span class="degree">{{ $currentForecast->windSpeed }} m/s</span></h3>
            <h3><span class="degree">{{ $currentForecast->temperature }} &deg;C</span>, {{ $currentForecast->icon }}. {{ $summary }}</h3>
            <h3>Feels like: <span class="degree">{{ $currentForecast->apparentTemperature }} &deg;C</span></h3>
        </div>
        <div class="row">
            <h2>24h forecast: </h2>
            @foreach($hourlyForecast as $key => $day)
                <div class="day">
                    <h3>{{ date('m.d H:i',$day->time) }}</h3>
                    <span class="temperature">
                        <span class="degree degree--small">{{ $day->temperature }} &deg;C</span> (feels like  <span class="degree degree--small">{{ $day->apparentTemperature }} &deg;C</span>)
                    </span>
                </div>
            @endforeach
        </div>
        <canvas id="myChart" width="400px" height="400px"></canvas>
        <div class="row">
            <h2>Forecast for 3 days: </h2>
            <div class="daily">
                @foreach($dailyForecast as $key => $day)
                    <div class="daily__item">
                        <h1><span class="degree">{{ date('M d Y',$day->time) }}</span></h1>
                        <p class="summary">{{ $day->summary }}</p>
                        @if($day->icon == 'rain')
                            <img class="icon" src="http://www.iconarchive.com/download/i89288/icons8/ios7/Weather-Rain.ico"/>
                        @elseif($day->icon == 'snow')
                            <img class="icon" src="https://d30y9cdsu7xlg0.cloudfront.net/png/64-200.png"/>
                        @elseif($day->icon == 'fog')
                            <img class="icon" src="https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQaw2r7ErK7CnwqssEY1ulDL6s0gZe7raDCUaovxK4WMSkDrwubiF2M7w"/>
                        @else
                            <img class="icon" src="https://www.colourbox.com/preview/5472017-weather-icon-sun-cloud.jpg"/>
                        @endif
                        <p><span class="heading">Pressure: </span><span class="degree">{{ $day->pressure }} mb</span></p>
                        <p><span class="heading">Humidity: </span><span class="degree">{{ $day->humidity }}%</span></p>
                        <p><span class="heading">Wind speed: </span><span class="degree">{{ $day->windSpeed }} m/s</span></p>
                        <hr style="width: 80%;">
                        <p><span class="heading">Min. temprature: </span><span class="degree">{{ $day->temperatureMin }} &deg;C ({{ date('H:i',$day->temperatureMinTime) }})</span></p>
                        <p class="addition">feels like <span class="degree">{{ $day->apparentTemperatureMin }} &deg;C</span></p>
                        <p><span class="heading">Max. temprature: </span><span class="degree">{{ $day->temperatureMax }} &deg;C ({{ date('H:i',$day->temperatureMaxTime) }})</span></p>
                        <p class="addition">feels like <span class="degree">{{ $day->apparentTemperatureMax }} &deg;C</span></p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row" style="margin-top: 50px;">
            <div class="item">
                <a href="{{ route('front.history') }}"><span>History</span></a>
            </div>
        </div>
    </div>
    <script>
        app.main.initChart();
    </script>
@endsection