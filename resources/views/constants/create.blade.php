@extends('layout.master')
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Content-->
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <!--begin::Post-->
                <div class="post d-flex flex-column-fluid  card card-flush h-lg-100" id="kt_post">
                    <!--begin::Container-->
                    <div id="kt_content_container" class="container-xxl">
                        <!--begin::Main column-->
                        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10 mt-10">
                            <form id="kt_modal_add_user_form" class="form" method="POST"
                                  action="{{route('constants.store')}}" enctype="multipart/form-data">
                                @include('validation.alerts')

                                @csrf
                                <!--begin::Separator-->
                                <div class="separator separator-dashed mt-6 mb-6"></div>
                                <!--end::Separator-->
                                <div class="row ">
                                    <!--begin::Col-->
                                    <div class="col-lg-4 ">

                                        <!--begin::Label-->
                                        <label class="form-label fs-5 fw-bold ">نسبة المكتب</label>
                                        <!--begin::Input-->
                                        <input type="number" name="ration" style="text-align: right;"
                                               class="form-control form-control-solid mb-3 mb-lg-0"
                                               placeholder="النسبة"
                                               step="0.01"
                                               min="0.00"
                                               max="100.00"
                                               value="{{getConstantByKey($constants,'ratio')->value}}"/>
                                        <!--end::Input-->
                                    </div>
                                    <!--begin::Col-->
                                    <!--begin::Col-->
                                    <div class="col-lg-4 ">

                                        <!--begin::Label-->
                                        <label class="form-label fs-5 fw-bold ">المبلغ الثابت </label>
                                        <!--begin::Input-->
                                        <input type="number" name="fix_amount" style="text-align: right;"
                                               class="form-control form-control-solid mb-3 mb-lg-0"
                                               placeholder="المبلغ الثابت"
                                               step="0.01"
                                               min="0.00"
                                               max="100.00"
                                               value="{{getConstantByKey($constants,'fix_amount')->value}}"/>
                                        <!--end::Input-->
                                    </div>
                                    <!--begin::Col-->
                                    <!--begin::Col-->
                                    <div class="col-lg-4 ">

                                        <!--begin::Label-->
                                        <label class="form-label fs-5 fw-bold "> مبلغ الاغلاق التلقائي </label>
                                        <!--begin::Input-->
                                        <input type="number" name="closed_amount" style="text-align: right;"
                                               class="form-control form-control-solid mb-3 mb-lg-0"
                                               placeholder="مبلغ الاغلاق التلقائي"
                                               step="0.01"
                                               min="0.00"
                                               max="100.00"
                                               value="{{getConstantByKey($constants,'closed_amount')->value}}"/>
                                        <!--end::Input-->
                                    </div>
                                    <!--begin::Col-->
                                </div>
                                <!--begin::Separator-->
                                <div class="separator separator-dashed mt-6 mb-6"></div>
                                <!--end::Separator-->
                                <!--begin::Actions-->
                                <div class="text-center pt-15">
                                    <button type="submit" class="btn btn-primary" id="kt_modal_add_role"
                                            data-kt-users-modal-action="submit">
                                        <span class="indicator-label">{{__('lang.submit')}}</span>
                                    </button>
                                </div>
                                <!--end::Actions-->

                            </form>
                        </div>

                        <!--end::Main column-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Post-->
            </div>
            <!--end::Content-->

        </div>
    </div>
@endsection
@section('scripts')
    <script>
       ["#kt_ecommerce_add_product_tags"].forEach((e => {
            const t = document.querySelector(e);
            t && new Tagify(t, {
                whitelist: ["new", "trending", "sale", "discounted", "selling fast", "last 10"],
                dropdown: {maxItems: 20, classname: "tagify__inline__suggestions", enabled: 0, closeOnSelect: !1}
            })
        }))
    </script>

@endsection

