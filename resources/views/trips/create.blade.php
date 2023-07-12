@extends('layout.master')
@section('content')

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->


            <div class="card">
                <!--begin:::Tabs-->
                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 form p-4 fw-bold mb-n2">
                    <!--begin:::Tab item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                           href="#kt_ecommerce_add_product_general">معلومات الرحلة</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general"
                         role="tab-panel">
                        <!--end:::Tabs-->
                        @include('validation.alerts')
                        <!--begin::Form-->
                        <form id="kt_docs_formvalidation_text" class="form p-4" method="post"
                              action="{{isset($item)?route('trips.store',['id'=>$item->id]):route('trips.store')}}"
                              autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!--begin::Input group-->
                                <!--begin::Col-->
                                <div class="col-lg-2 mt-8">
                                    <!--begin::Heading-->

                                    <!--begin::Radio group-->
                                    <div class="btn-group w-100 " data-kt-buttons="true"
                                         data-kt-buttons-target="[data-kt-button]">
                                        <!--begin::Radio-->
                                        <label
                                            class="btn btn-outline btn-color-muted btn-active-primary {{!isset($item) || isset($item) && !$item->is_owner_place?'active':''}}"
                                            data-kt-button="true">
                                            <!--begin::Input-->
                                            <input class="btn-check" id="customer_radio_btn"
                                                   @if(!isset($item) || isset($item) && !$item->is_owner_place)
                                                       checked="checked"
                                                   @endif
                                                   type="radio" name="owner" value="customer"/>
                                            <!--end::Input-->
                                            زبون
                                        </label>
                                        <!--end::Radio-->

                                        <!--begin::Radio-->
                                        <label
                                            class="btn btn-outline btn-color-muted btn-active-primary {{isset($item) && $item->is_owner_place?'active':''}}"
                                            data-kt-button="true">
                                            <!--begin::Input-->
                                            <input class="btn-check" type="radio" id="place_radio_btn"
                                                   name="owner"
                                                   @if(isset($item) && $item->is_owner_place)
                                                       checked="checked"
                                                   @endif
                                                   value="place"/>
                                            <!--end::Input-->
                                            مكان
                                        </label>
                                        <!--end::Radio-->


                                    </div>
                                    <!--end::Radio group-->

                                </div>
                                <!--begin::Col-->

                                <!--begin::Col-->
                                <div class="col-lg-4 mt-1" id="customer">
                                    <!--begin::Label-->
                                    <label class="form-label fs-5 fw-bold ">زبائن</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-select form-select-solid  w-250px fw-bolder "
                                            data-kt-select2="true" data-placeholder="{{__('lang.select')}}"
                                            data-allow-clear="true" id="customer_filter" name="customer_id">
                                        <option></option>
                                        @foreach($customers as $customer)
                                            <option
                                                value="{{$customer->id}}" {{isset($item)?($customer->id == @$item->owner->id?'selected':''):''}}>{{$customer->name}}
                                                - {{$customer->phone}}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-4 mt-1" id="place">
                                    <!--begin::Label-->
                                    <label class="form-label fs-5 fw-bold ">أماكن</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-select form-select-solid  w-250px fw-bolder "
                                            data-kt-select2="true" data-placeholder="{{__('lang.select')}}"
                                            data-allow-clear="true" id="place_filter" name="place_id">
                                        <option></option>
                                        @foreach($places as $place)
                                            <option
                                                value="{{$place->id}}" {{isset($item)?($place->id == @$item->owner->id?'selected':''):''}}>{{$place->name}}
                                                - {{$place->phone}}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                    @foreach($places as $place)
                                        <input type="hidden" value="{{$place->address}}" id="place_address_{{$place->id}}"/>
                                    @endforeach
                                </div>
                                <!--end::Col-->

                                <!--begin::Col-->
                                <div class="col-lg-4 mt-1">
                                    <!--begin::Label-->
                                    <label class="form-label fs-5 fw-bold ">كباتن</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-select form-select-solid  w-250px fw-bolder " name="captain_id"
                                            data-kt-select2="true" data-placeholder="{{__('lang.select')}}"
                                            data-allow-clear="true" id="captain_filter">
                                        <option></option>
                                        @foreach($captains as $captain)
                                            <option
                                                value="{{$captain->id}}" {{isset($item)?($captain->id == @$item->captain->id?'selected':''):''}}>{{$captain->name}}
                                                - {{$captain->phone}}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->


                            </div>
                            <!--begin::Separator-->
                            <div class="separator separator-dashed mt-6 mb-6"></div>
                            <!--end::Separator-->
                            <div class="row ">
                                <!--begin::Col-->
                                <div class="col-lg-12 ">

                                    <!--begin::Label-->
                                    <label class="form-label fs-5 fw-bold ">السعر</label>
                                    <!--begin::Input-->
                                    <input type="number" name="amount" style="text-align: right;"
                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="السعر"
                                           value="{{isset($item)?$item->amount:old('amount')}}"/>
                                    <!--end::Input-->
                                </div>
                                <!--begin::Col-->
                            </div>
                            <!--begin::Separator-->
                            <div class="separator separator-dashed mt-6 mb-6"></div>
                            <!--end::Separator-->
                            <div class="row ">
                                <!--begin::Col-->
                                <div class="col-lg-6 ">
                                    <div class="fv-row w-100 flex-md-root">
                                        <!--begin::Label-->
                                        <label class="form-label">من</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <textarea name="from" id="from"
                                                  class="form-control mb-2">{{isset($item)?$item->from:old('from')}}</textarea>
                                        <!--end::Input-->

                                    </div>

                                </div>
                                <!--begin::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-6 ">
                                    <div class="fv-row w-100 flex-md-root">
                                        <!--begin::Label-->
                                        <label class="form-label">الى</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <textarea name="to"
                                                  class="form-control mb-2">{{isset($item)?$item->to:old('to')}}</textarea>
                                        <!--end::Input-->
                                    </div>

                                </div>
                                <!--begin::Col-->
                            </div>
                            @if(isset($item)  && $item->status != \App\Constants\Enum::COMPLETED)
                                <!--begin::Separator-->
                                <div class="separator separator-dashed mt-6 mb-6"></div>
                                <!--end::Separator-->
                                <div class="row ">
                                    <!--begin::Col-->
                                    <div class="col-lg-4 ">
                                        <div class="mb-4">
                                            الحالة :
                                        </div>
                                        <div class="d-flex">
                                            <div class="form-check form-check-custom form-check-solid me-10">
                                                <input class="form-check-input h-30px w-30px" type="radio" name="status"
                                                       @if(!isset($item) || isset($item) && $item->status == \App\Constants\Enum::PENDING)
                                                           checked="checked"
                                                       @endif
                                                       value="pending" id="flexCheckbox30"/>
                                                <label class="form-check-label" for="flexCheckbox30">
                                                    غير مكتملة
                                                </label>
                                            </div>

                                            <div class=" form-check form-check-custom form-check-solid me-10">
                                                <input class="form-check-input h-30px w-30px" type="radio" name="status"
                                                       @if( isset($item) && $item->status == \App\Constants\Enum::CANCELED)
                                                           checked="checked"
                                                       @endif
                                                       value="canceled" id="flexCheckbox40"/>
                                                <label class="form-check-label" for="flexCheckbox40">
                                                    الغاء
                                                </label>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                                <!--begin::Separator-->
                                @endif

                            <div class="separator separator-dashed mt-6 mb-6"></div>
                            <div class="row ">
                                <!--begin::Col-->
                                @if(isset($item))
                                    <!--begin::Col-->
                                    <div class="col-lg-4 ">
                                        <div class="fv-row w-100 flex-md-root">

                                            الحالة الحالية :
                                            <label class="checkbox badge badge-light-{{getClassByStatus($item->status)}}">
                                                {{getStatusStr($item->status)}}

                                            </label>
                                        </div>


                                    </div>
                                    <!--begin::Col-->
                                    <!--begin::Col-->
                                    <div class="col-lg-4 ">
                                        <div class="fv-row w-100 flex-md-root">

                                            مغلقة/غير مدخلة  :
                                            <label class="checkbox badge badge-light-{{!is_null($item->amount) && $item->amount >0?'success':'danger'}}">
                                                {{!is_null($item->amount) && $item->amount >0?'مغلقة':'غير مدخلة'}}
                                            </label>
                                        </div>


                                    </div>
                                    <!--begin::Col-->
                                @endif

                            </div>
                            <!--begin::Separator-->
                            <div class="separator separator-dashed mt-6 mb-6"></div>
                            <!--end::Separator-->

                            <!--begin::Actions-->
                            <button id="kt_docs_formvalidation_text_submit1" type="submit" class="btn btn-primary">
                        <span class="indicator-label">
                           {{__('lang.submit')}}
                        </span>
                                <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                            </button>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                </div>

            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            // Show/hide divs based on the selected radio button
            $('input[name="owner"]').on('change', function () {
                var selectedValue = $(this).val();
                if (selectedValue === 'customer') {
                    $('#place').hide();
                    $('#customer').show();
                } else if (selectedValue === 'place') {
                    $('#customer').hide();
                    $('#place').show();
                }
            });
            $('#place_filter').on('change', function () {
                var html =  $('#place_address_'+$(this).val()).val()
                $('#from').html(html)
            });


            @if(isset($item) && $item->is_owner_place)
            $('#place_radio_btn').prop('checked', true);
            $('#customer').hide();
            @else
            $('#customer_radio_btn').prop('checked', true);
            $('#place').hide();
            @endif

        });

    </script>
@endsection
