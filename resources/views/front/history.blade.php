@extends('layout')

@section('content')
    <div class="container history">
        <div class="row">
            <h1>Last {{ count($items) }} people's queries:</h1>
            <div id="map"></div><br/>
            @foreach($items as $item)
                <p><a class="item-link" href="{{ route('front.prepareForecast',array('lng'=>$item->lng,'lat'=>$item->lat,'name'=>$item->name)) }}">{{ $item->name }}</a></p><hr style="width: 60%;">
            @endforeach
        </div>
    </div>
    <script>
        app.maps.initHistoryMap();
    </script>
@endsection