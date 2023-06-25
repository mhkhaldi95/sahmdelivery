<div class="d-flex align-items-center text-end">

    @php
    $item = isset($item)?$item:null;
        $route = '#';
        if($item->owner){
            if($item->owner->role == \App\Constants\Enum::PLACE){
                $route = 'places.create';
            }else{
                $route = 'customers.create';
            }

        }
    @endphp
    <div class="">
        <!--begin::Title-->
        <a href="{{ $route == '#'?'#'  : route($route,@$item->owner->id)}}" class="text-gray-800 text-hover-primary fs-5 fw-bolder" data-kt-ecommerce-product-filter="product_name">{{@$item->owner->name}}</a>
        <!--end::Title-->
    </div>
</div>
