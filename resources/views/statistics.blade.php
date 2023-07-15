@extends('layout.master')
@section('content')

    @php
        $data_from = null;
        $data_to = null;
        $is_exist_request  = request('datefilter') && !empty(request('datefilter')) && !is_null(request('datefilter'));
        if($is_exist_request){
            $data_from = explodeDate()[0];
            $data_to = explodeDate()[1];
        }
    @endphp
    <input type="hidden" id="date_from" value="{{$data_from}}">
    <input type="hidden" id="date_to" value="{{$data_to}}">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">

            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{route('statistics.index')}}">
                        <div class="row g-5 g-xl-8">
                            <div class="col-lg-3 mt-1">
                                <!--begin::Label-->
                                <label class="form-label fs-5 fw-bold ">من - الى</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-solid" name="datefilter"
                                       placeholder="اختر التاريخ" value=""/>

                                <!--end::Input-->
                            </div>
                            <!--begin::Col-->
                            <div class="col-lg-3 mt-1">
                                <!--begin::Label-->
                                <label class="form-label fs-5 fw-bold ">كباتن</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-select form-select-solid  w-250px fw-bolder "
                                        data-kt-select2="true" data-placeholder="{{__('lang.select')}}"
                                        data-allow-clear="true" name="captain_id" id="captain_filter">
                                    <option></option>
                                    @foreach($captains as $captain)
                                        <option
                                            value="{{$captain->id}}" {{request('captain_id') == $captain->id?'selected':''}}>{{$captain->name}}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-lg-3 mt-10">
                                <button type="submit" class="btn btn-primary">بحث</button>
                            </div>
                            <!--end::Col-->

                        </div>
                    </form>


                </div>

            </div>
            <!--begin::Row-->
            <div class="card mt-1">
                <div class="card-body">
                    <div class="row g-5 g-xl-8">
                        <div class="col-xl-3">
                            <!--begin::Statistics Widget 5-->
                            <a href="#" class="card bg-info hoverable card-xl-stretch mb-xl-8">
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen008.svg-->
                                    <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                            </span>
                                    <!--end::Svg Icon-->

                                    <div class="fw-bold text-white fs-2">عدد الرحلات الاجمالي :
                                        {{$trip_count}}
                                    </div>
                                </div>
                                <!--end::Body-->
                            </a>
                            <!--end::Statistics Widget 5-->
                        </div>
                        <div class="col-xl-3">
                            <!--begin::Statistics Widget 5-->
                            <a href="#" class="card bg-success hoverable card-xl-stretch mb-xl-8">
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen008.svg-->
                                    <span class="svg-icon svg-icon-white svg-icon-3x ms-n1"></span>
                                    <!--end::Svg Icon-->
                                    <div class="fw-bold text-white fs-2"  style="font-size: 16px;">عدد الرحلات المكتملة :
                                        {{$complete_trip_count}}

                                    </div>
                                </div>
                                <!--end::Body-->
                            </a>
                            <!--end::Statistics Widget 5-->
                        </div>
                        <div class="col-xl-3">
                            <!--begin::Statistics Widget 5-->
                            <a href="#" class="card bg-primary hoverable card-xl-stretch mb-xl-8">
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen008.svg-->
                                    <span class="svg-icon svg-icon-white svg-icon-3x ms-n1"></span>
                                    <!--end::Svg Icon-->
                                    <div class="fw-bold text-white fs-2"  style="font-size: 16px;">عدد الرحلات  الغير المكتملة :
                                        {{$pending_trip_count}}

                                    </div>
                                </div>
                                <!--end::Body-->
                            </a>
                            <!--end::Statistics Widget 5-->
                        </div>
                        <div class="col-xl-3">
                            <!--begin::Statistics Widget 5-->
                            <a href="#" class="card bg-danger hoverable card-xl-stretch mb-xl-8">
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen008.svg-->
                                    <span class="svg-icon svg-icon-white svg-icon-3x ms-n1"></span>
                                    <!--end::Svg Icon-->
                                    <div class="fw-bold text-white fs-2"  style="font-size: 16px;">عدد الرحلات   الملغية :
                                        {{$canceled_trip_count}}

                                    </div>
                                </div>
                                <!--end::Body-->
                            </a>
                            <!--end::Statistics Widget 5-->
                        </div>


                    </div>
                   <h3 class="badge badge-light-danger mt-1 mb-3">  المبالغ المحصلة</h3>
                    <div class="row">
                        <div class="col-xl-4">
                            <!--begin::Statistics Widget 5-->
                            <a href="#" class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8">
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr070.svg-->
                                    <span class="svg-icon svg-icon-gray-100 svg-icon-3x ms-n1">
                            </span>
                                    <!--end::Svg Icon-->
                                    <div class="text-gray-100 fw-bolder fs-2 mb-2 mt-5"></div>
                                    <div class="fw-bold text-gray-100" style="font-size: 16px;">المبلغ الاجمالي للرحلات
                                        :
                                        {{$total_amount}}
                                    </div>
                                </div>
                                <!--end::Body-->
                            </a>
                            <!--end::Statistics Widget 5-->
                        </div>
                        <div class="col-xl-4">
                            <!--begin::Statistics Widget 5-->
                            <a href="#" class="card bg-danger hoverable card-xl-stretch mb-5 mb-xl-8">
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr070.svg-->
                                    <span class="svg-icon svg-icon-gray-100 svg-icon-3x ms-n1">

                            </span>


                                    <!--end::Svg Icon-->
                                    <div class="text-gray-100 fw-bolder fs-2 mb-2 mt-5"></div>
                                    <div class="fw-bold text-gray-100" style="font-size: 16px;">المبلغ الاجمالي للمكتب :
                                        {{$total_amount_for_office}}
                                    </div>
                                </div>
                                <!--end::Body-->
                            </a>
                            <!--end::Statistics Widget 5-->
                        </div>
                        <div class="col-xl-4">
                            <!--begin::Statistics Widget 5-->
                            <a href="#" class="card bg-dark hoverable card-xl-stretch mb-5 mb-xl-8">
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr070.svg-->
                                    <span class="svg-icon svg-icon-gray-100 svg-icon-3x ms-n1">

                            </span>


                                    <!--end::Svg Icon-->
                                    <div class="text-gray-100 fw-bolder fs-2 mb-2 mt-5"></div>
                                    <div class="fw-bold text-gray-100">المبلغ الاجمالي للكباتن :
                                        {{$total_amount_for_captain}}
                                    </div>
                                </div>
                                <!--end::Body-->
                            </a>
                            <!--end::Statistics Widget 5-->
                        </div>
                    </div>
                </div>
            </div>

            <!--end::Row-->
        </div>
    </div>
@endsection
@section('scripts')

    <script type="text/javascript">
        $(function () {

            $('input[name="datefilter"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('input[name="datefilter"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });




            // $('input[name="datefilter"]').data('daterangepicker').setStartDate('03/01/2014');
            // $('input[name="datefilter"]').daterangepicker({ startDate: '03/05/2005', endDate: '03/06/2005' });


        });
        $(document).ready(function () {
            var date_from = $('#date_from').val();
            var date_to = $('#date_to').val();
            if (date_to && date_from) {
                $('input[name="datefilter"]').daterangepicker({startDate: date_from, endDate: date_to});
            }
            $('input[name="datefilter"]').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });
        })
    </script>
@endsection
