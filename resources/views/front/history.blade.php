@extends('layout')
@section('javascript')
<script>
    app.uploadHistoryUrl = "{{ route('front.loadHistory')}}";
</script>
@endsection
@section('content')
    <div class="container history">
        <div class="row">
            @if(count($items))
                <h1>Last {{ count($items) }} people's queries:</h1>
                <div id="map"></div><br/>
                <hr style="width: 60%;">
                @foreach($items as $key => $item)
                    <p><a class="item-link" href="{{ route('front.prepareForecast',array('lng'=>$item->lng,'lat'=>$item->lat,'name'=>$item->name)) }}">{{ $item->name }}</a></p><hr style="width: 60%;">
                    @if($key == count($items) - 1)
                        <input type="hidden" value="{{ $item->id }}" class="last-id">
                    @endif
                @endforeach
                <div class="insert-before"></div>
                @if(count($items) == 10)
                    <h1 class='load-more' data-user="0" id="load">Load more</h1>
                    <p class="load-more__message"></p>
                @endif
            @else
                <h1>Sorry, there are no any result in DB yet.</h1>
            @endif
        </div>
    </div>
    <script>
        app.maps.initHistoryMap();
        app.main.initHistoryLoad();
    </script>
@endsection