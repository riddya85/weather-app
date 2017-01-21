@foreach($items as $key => $item)
    <p><a class="item-link" @if($key == count($items) - 1) data-hid="{{ $item->id }}" @endif href="{{ route('front.prepareForecast',array('lng'=>$item->lng,'lat'=>$item->lat,'name'=>$item->name)) }}">{{ $item->name }}</a></p><hr style="width: 60%;">
@endforeach