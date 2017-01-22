@extends('layout')
@section('javascript')
<script>
    app.uploadHistoryUrl = "{{ route('front.loadHistory')}}";
</script>
@endsection
@section('content')
    <div class="container history">
        <div class="row">
            <h1>{{ $user->name }}</h1>
            @if(count($items))
                <p class="subline">This is your last {{ count($items) }} queries: </p>
                <div id="map"></div>
                <br/>
                <hr style="width: 60%;">
                @foreach($items as $key => $item)
                    <p><a class="item-link" href="{{ route('front.prepareForecast',array('lng'=>$item->lng,'lat'=>$item->lat,'name'=>$item->name)) }}">{{ $item->name }}</a></p><hr style="width: 60%;">
                    @if($key == count($items) - 1)
                        <input type="hidden" value="{{ $item->id }}" class="last-id">
                    @endif
                @endforeach
                <div class="insert-before"></div>
                @if(count($items) == 5)
                    <h1 class='load-more' data-user="{{ $user->id }}" id="load">Load more</h1>
                    <p class="load-more__message"></p>
                @endif
            @else
                <p class="subline">Sorry, you don't have any query history yet.</p>
            @endif
        </div>
    </div>
    <script>
        app.maps.initHistoryMap();
        app.main.initHistoryLoad();
    </script>
@endsection