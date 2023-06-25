
@if($item->amount)
    <div class="badge badge-light-success amount" data-amount="{{$item->amount}}" data-id="{{$item->id}}"  style="color: black">
        {{$item->amount}} <span style='font-size:16px;'>&#8362;</span>
    </div>
    @else
    <div class="badge badge-light-warning  amount" data-amount="0" data-id="{{$item->id}}" >
غير مدخلة    </div>
@endif

