@extends('layout')

@section('content')
    <div class="container home">
        <div class="row">
            <h1>Type any place you want:</h1>
            <form action="{{ route('front.prepareForecast',array(0,0)) }}" method="POST" >
                <input type="text" id="city" class="search" name="city" placeholder="Location..."/>

                <input type="hidden" id="lng" name="lng" value="0"/>
                <input type="hidden" id="lat" name="lat" value="0"/>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit" id="submitSearch" value="Search"/>
            </form>
        </div>
        <div id="map" style="width: 500px; height: 300px; margin: 0 auto; margin-top: 60px;"></div>
        <div class="row" style="margin-top: 100px;">
            <div class="item">
                <span>History</span>
            </div>
            {{--<div class="item">--}}
                {{--<span>Something</span>--}}
            {{--</div>--}}
            {{--<div class="item">--}}
                {{--<span>Food</span>--}}
            {{--</div>--}}
        </div>
    </div>
    <script>
        app.maps.init();
    </script>
@endsection