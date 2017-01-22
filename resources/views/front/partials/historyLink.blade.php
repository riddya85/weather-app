@foreach($items as $key => $item)
    <p><a class="item-link" href="{{ route('front.prepareForecast',array('lng'=>$item->lng,'lat'=>$item->lat,'name'=>$item->name)) }}">{{ $item->name }}</a></p><hr style="width: 60%;">
    @if($key == count($items) - 1)
        <input type="hidden" value="{{ $item->id }}" class="last-id">
    @endif
@endforeach