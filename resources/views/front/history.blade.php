@extends('layout')

@section('content')
    <div class="container home">
        <div class="row">
            <h1>Last 10 people's queries:</h1>
            @foreach($items as $item)
                <p><a href="{{ route('front.prepareForecast',array($item->lng,$item->lat)) }}">{{ $item->name }}</a></p>
            @endforeach
        </div>
        <div id="map" style="width: 500px; height: 300px; margin: 0 auto; margin-top: 60px;"></div>
    </div>
    <script>
        app.maps.init();
    </script>
@endsection