<div class="form-check form-check-sm form-check-custom form-check-solid">
    @if($item->status == \App\Constants\Enum::PENDING)
        <input class="form-check-input" type="checkbox" value="{{$item->id}}"/>
    @endif
</div>
