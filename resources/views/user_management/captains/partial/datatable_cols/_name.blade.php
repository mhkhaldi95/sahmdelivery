<div class="d-flex align-items-center text-end">
    <!--begin::Thumbnail-->
    <a href="#" class="symbol symbol-50px">
        <span class="symbol-label" style="background-image:url({{$item->photo_path}});"></span>
    </a>
    <!--end::Thumbnail-->
    <div class="ms-5">
        <!--begin::Title-->
        <a href="{{route('captains.create',$item->id)}}" class="text-gray-800 text-hover-primary fs-5 fw-bolder" data-kt-ecommerce-product-filter="product_name">{{$item->name}}</a>
        <!--end::Title-->
    </div>
</div>
