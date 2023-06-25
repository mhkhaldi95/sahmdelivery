
@if($item->amount)
    <div class="badge badge-light-success" style="color: black">
        {{$item->amount}} <span style='font-size:16px;'>&#8362;</span>
    </div>
    @else
    <div class="badge badge-light-warning ">
غير مدخلة    </div>
@endif

