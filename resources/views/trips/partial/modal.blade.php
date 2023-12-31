<div class="modal" id="update_amount_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="text-align: center">
                <!--begin::Separator-->
                <div class="separator separator-dashed mt-6 mb-6"></div>
                <!--end::Separator-->
                <div class="row ">
                    <!--begin::Col-->
                    <div class="col-lg-12 ">

                        <!--begin::Label-->
                        <label class="form-label fs-5 fw-bold "> السعر</label>
                        <!--begin::Input-->
                        <input type="number" id="amount" name="amount" style="text-align: right;"
                               class="form-control form-control-solid mb-3 mb-lg-0"
                               placeholder="السعر "
                               min="1"
                               step="1"
                               value="4"/>
                        <!--end::Input-->
                    </div>
                    <!--begin::Col-->
                </div>
                <!--begin::Separator-->
                <div class="separator separator-dashed mt-6 mb-6"></div>

            </div>
            <div class="modal-footer" style="justify-content:center">
                <button type="button" id="submit" class="btn btn-primary">تعديل</button>
                <button type="button" id="cancel" class="btn btn-danger">الغاء</button>
            </div>
        </div>
        <!-- Modal footer -->
    </div>
</div>
<div class="modal" id="update_from_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="text-align: center">
                <!--begin::Separator-->
                <div class="separator separator-dashed mt-6 mb-6"></div>
                <!--end::Separator-->
                <div class="row ">
                    <!--begin::Col-->
                    <div class="col-lg-12 ">

                        <!--begin::Label-->
                        <label class="form-label fs-5 fw-bold "> من</label>
                        <!--begin::Input-->
                        <!--begin::Input-->
                        <textarea name="from" id="from" class="form-control mb-2"></textarea>
                        <!--end::Input-->
                    </div>
                    <!--begin::Col-->
                </div>
                <!--begin::Separator-->
                <div class="separator separator-dashed mt-6 mb-6"></div>

            </div>
            <div class="modal-footer" style="justify-content:center">
                <button type="button" id="submit_from" class="btn btn-primary">تعديل</button>
                <button type="button" id="cancel_from" class="btn btn-danger">الغاء</button>
            </div>
        </div>
        <!-- Modal footer -->
    </div>
</div>
<div class="modal" id="update_to_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="text-align: center">
                <!--begin::Separator-->
                <div class="separator separator-dashed mt-6 mb-6"></div>
                <!--end::Separator-->
                <div class="row ">
                    <!--begin::Col-->
                    <div class="col-lg-12 ">

                        <!--begin::Label-->
                        <label class="form-label fs-5 fw-bold "> الى</label>
                        <!--begin::Input-->
                        <!--begin::Input-->
                        <textarea name="to" id="to" class="form-control mb-2"></textarea>
                        <!--end::Input-->
                    </div>
                    <!--begin::Col-->
                </div>
                <!--begin::Separator-->
                <div class="separator separator-dashed mt-6 mb-6"></div>

            </div>
            <div class="modal-footer" style="justify-content:center">
                <button type="button" id="submit_to" class="btn btn-primary">تعديل</button>
                <button type="button" id="cancel_to" class="btn btn-danger">الغاء</button>
            </div>
        </div>
        <!-- Modal footer -->
    </div>
</div>


<!--begin::Modal - Customers - Add-->
<div class="modal" id="trip_create_modal" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-950px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form id="trip_form" class="form p-4" method="post"
                  action="{{isset($item)?route('trips.store',['id'=>$item->id]):route('trips.store')}}"
                  autocomplete="off" enctype="multipart/form-data">
                @csrf
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_customer_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder">اضافة رحلة</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="kt_modal_add_customer_close"
                         class="btn btn-icon btn-sm btn-active-icon-primary close_trip_create_modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
															<svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                 height="24" viewBox="0 0 24 24" fill="none">
																<rect opacity="0.5" x="6" y="17.3137" width="16"
                                                                      height="2" rx="1"
                                                                      transform="rotate(-45 6 17.3137)"
                                                                      fill="currentColor"/>
																<rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                                      transform="rotate(45 7.41422 6)"
                                                                      fill="currentColor"/>
															</svg>
														</span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-10 px-lg-17">
                    <!--begin::Scroll-->
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll" data-kt-scroll="true"
                         data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#kt_modal_add_customer_header"
                         data-kt-scroll-wrappers="#kt_modal_add_customer_scroll" data-kt-scroll-offset="300px">
                        <div class="row">
                            <!--begin::Input group-->
                            <!--begin::Col-->
                            <div class="col-lg-4 mt-8">
                                <!--begin::Heading-->

                                <!--begin::Radio group-->
                                <div class="btn-group w-100 " data-kt-buttons="true"
                                     data-kt-buttons-target="[data-kt-button]">
                                    <!--begin::Radio-->

                                    <!--end::Radio-->

                                    <!--begin::Radio-->
                                    <label
                                        class="btn btn-outline btn-color-muted btn-active-primary {{ !isset($item) ||   $item->is_owner_place?'active':''}}"
                                        data-kt-button="true" id="place-label">
                                        <!--begin::Input-->
                                        <input class="btn-check" type="radio" id="place_radio_btn"
                                               name="owner"
                                               @if(!isset($item) ||   $item->is_owner_place)
                                                   checked="checked"
                                               @endif
                                               value="place"/>
                                        <!--end::Input-->
                                        مكان
                                    </label>
                                    <!--end::Radio-->

                                    <label
                                        class="btn btn-outline btn-color-muted btn-active-primary  {{isset($item) && !$item->is_owner_place?'active':''}}"
                                        data-kt-button="true" id="customer-label">
                                        <!--begin::Input-->
                                        <input class="btn-check" id="customer_radio_btn"
                                               @if(isset($item) && !$item->is_owner_place)
                                                   checked="checked"
                                               @endif
                                               type="radio" name="owner" value="customer"/>
                                        <!--end::Input-->
                                        زبون
                                    </label>


                                </div>
                                <!--end::Radio group-->

                            </div>
                            <!--begin::Col-->


                            <div class="col-lg-8 mt-1" id="customer">
                                <div class="row">
                                    <div class="col-lg-9" id="exist-customer-section">
                                        <!--begin::Label-->
                                        <label class="form-label fs-5 fw-bold ">زبائن</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select class="form-select form-select-solid   fw-bolder  select-modal"
                                                data-kt-select2="true" data-placeholder="{{__('lang.select')}}"
                                                data-allow-clear="true" id="customer_select2" name="customer_id">
                                            <option></option>
                                            @foreach($active_customers as $customer)
                                                <option
                                                    value="{{$customer->id}}" {{isset($item)?($customer->id == @$item->owner->id?'selected':''):''}}>{{$customer->name}}
                                                    - {{$customer->phone}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-3 mt-8" id="add_customer">
                                        <!--begin::Action-->
                                        <div  class="ms-auto">
                                            <button class="btn btn-primary ">اضافة زبون</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 mt-8  d-none" id="cancel_add_customer">
                                        <!--end::Action-->
                                        <!--begin::Action-->
                                        <div  class="ms-auto">
                                            <button class="btn btn-danger "> الغاء اضافة زبون</button>
                                        </div>
                                        <!--end::Action-->
                                    </div>

                                </div>
                            </div>


                            <!--begin::Col-->

                            <div id="add_customer_form" class="flex-row-fluid row d-none mt-3" style="background-color: #F5F8FA;margin-right: 10px">
                                <div class="separator separator-dashed mt-6 mb-6"></div>
                                <!--begin::Input group-->
                                <div class="col-6 mb-10 "  >
                                    <!--begin::Label-->
                                    <label class=" fw-semibold fs-6 mb-2">اسم الزبون</label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <input type="text" name="customer_name" id="customer_name" class="form-control  mb-3 mb-lg-0"
                                           placeholder="الاسم" value=""/>
                                    <!--end::Input-->
                                </div>

                                <!--begin::Input group-->
                                <div class="col-6 mb-10">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold fs-6 mb-2">{{__('lang.phone')}}</label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <input type="text" name="customer_phone" id="customer_phone" class="form-control  mb-3 mb-lg-0"
                                           placeholder="{{__('lang.phone')}}"
                                           value="{{old('phone')}}"/>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>


                            <!--begin::Col-->
                            <div class="col-lg-8 mt-1" id="place">
                                <div class="row">
                                    <div class="col-lg-9" id="exist-place-section">
                                        <!--begin::Label-->
                                        <label class="form-label fs-5 fw-bold ">أماكن</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select class="form-select form-select-solid  fw-bolder  select-modal"
                                                data-kt-select2="true" data-placeholder="{{__('lang.select')}}"
                                                data-allow-clear="true" id="place_select2" name="place_id">
                                            <option></option>
                                            @foreach($active_places as $place)
                                                <option
                                                    value="{{$place->id}}" {{isset($item)?($place->id == @$item->owner->id?'selected':''):''}}>{{$place->name}}
                                                    - {{$place->phone}}</option>
                                            @endforeach
                                        </select>
                                        <!--end::Input-->

                                        <div id="place_address">
                                            @foreach($active_places as $place)
                                                <input type="hidden" value="{{$place->address}}"
                                                       id="place_address_{{$place->id}}"/>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-lg-3 mt-8" id="add_place">
                                        <!--begin::Action-->
                                        <div  class="ms-auto">
                                            <button class="btn btn-primary ">اضافة مكان</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 mt-8  d-none" id="cancel_add_place">
                                        <!--end::Action-->
                                        <!--begin::Action-->
                                        <div  class="ms-auto">
                                            <button class="btn btn-danger "> الغاء اضافة مكان</button>
                                        </div>
                                        <!--end::Action-->
                                    </div>
                                </div>



                            </div>
                            <!--end::Col-->
                            <div id="add_place_form" class="flex-row-fluid row d-none mt-3" style="background-color: #F5F8FA;margin-right: 10px">
                                <div class="separator separator-dashed mt-6 mb-6"></div>
                                <!--begin::Input group-->
                                <div class="col-6 mb-10 "  >
                                    <!--begin::Label-->
                                    <label class=" fw-semibold fs-6 mb-2">اسم المكان</label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <input type="text" name="place_name" id="place_name" class="form-control  mb-3 mb-lg-0"
                                           placeholder="الاسم" value=""/>
                                    <!--end::Input-->
                                </div>

                                <!--begin::Input group-->
                                <div class="col-6 mb-10">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold fs-6 mb-2">{{__('lang.phone')}}</label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <input type="text" name="place_phone" id="place_phone" class="form-control  mb-3 mb-lg-0"
                                           placeholder="{{__('lang.phone')}}"
                                           value="{{old('phone')}}"/>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>

                            <!--begin::Col-->


                        </div>
                        <!--begin::Separator-->
                        <div class="separator separator-dashed mt-6 mb-6"></div>
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-12 mt-1">
                                <!--begin::Label-->
                                <label class="form-label fs-5 fw-bold ">كباتن</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-select form-select-solid  fw-bolder select-modal" name="captain_id"
                                        data-kt-select2="true" data-placeholder="{{__('lang.select')}}"
                                        data-allow-clear="true" id="captain_select2">
                                    <option></option>
                                                                        @foreach($active_captains as $captain)
                                                                            <option
                                                                                value="{{$captain->id}}" {{isset($item)?($captain->id == @$item->captain->id?'selected':''):''}}>{{$captain->name}}
                                                                                - {{$captain->phone}}</option>
                                                                        @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
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
                                       id="amount_trip_modal"
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
                                    <textarea name="from" id="from_trip_modal"
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
                                    <textarea name="to" id="to_trip_modal"
                                              class="form-control mb-2">{{isset($item)?$item->to:old('to')}}</textarea>
                                    <!--end::Input-->
                                </div>

                            </div>
                            <!--begin::Col-->
                        </div>
                        <!--begin::Separator-->

                        <!--begin::Separator-->
                        <div class="separator separator-dashed mt-6 mb-6"></div>



                    </div>
                    <!--end::Scroll-->
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">

                    <!--begin::Actions-->
                    <button type="button" id="trip_create_submit"  onclick="disableButton('trip_create_submit')" class="btn btn-primary">
                        <span class="indicator-label">
                           {{__('lang.submit')}}
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                    <!--end::Actions-->

                    <!--begin::Button-->
                    <button type="button" class="btn btn-light me-3 close_trip_create_modal">الغِ</button>
                    <!--end::Button-->

                </div>
                <!--end::Modal footer-->

                <input type="hidden" id="add-or-cancel-customer" value="1">
                <input type="hidden" id="add-or-cancel-place" value="1">
            </form>
            <!--end::Form-->
        </div>
    </div>
</div>
<!--end::Modal - Customers - Add-->
