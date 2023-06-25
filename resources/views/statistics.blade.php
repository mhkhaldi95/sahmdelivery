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
                        <div class="col-xl-6">
                            <!--begin::Statistics Widget 5-->
                            <a href="#" class="card bg-primary hoverable card-xl-stretch mb-xl-8">
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen008.svg-->
                                    <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                            </span>
                                    <!--end::Svg Icon-->
                                    <div class="text-white fw-bolder fs-2 mb-2 mt-5"> الرحلات</div>
                                    <div class="fw-bold text-white" style="font-size: 16px;">عدد الرحلات الاجمالي :
                                        {{$trip_count}}

                                    </div>
                                </div>
                                <!--end::Body-->
                            </a>
                            <!--end::Statistics Widget 5-->
                        </div>
                        <div class="col-xl-6">
                            <!--begin::Statistics Widget 5-->
                            <a href="#" class="card bg-success hoverable card-xl-stretch mb-xl-8">
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen008.svg-->
                                    <span class="svg-icon svg-icon-white svg-icon-3x ms-n1"></span>
                                    <!--end::Svg Icon-->
                                    <div class="text-white fw-bolder fs-2 mb-2 mt-5"> الرحلات المكتملة</div>
                                    <div class="fw-bold text-white" style="font-size: 16px;">عدد الرحلات المكتملة :
                                        {{$complete_trip_count}}

                                    </div>
                                </div>
                                <!--end::Body-->
                            </a>
                            <!--end::Statistics Widget 5-->
                        </div>
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
                             <svg fill="#FFFFFF" height="800px" width="800px" version="1.1" id="Layer_1"
                                  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                  viewBox="0 0 491.623 491.623" xml:space="preserve">
<g>
	<g>
		<path d="M430.182,368.696c-33.874,0-61.44,27.566-61.44,61.44c0,33.874,27.566,61.44,61.44,61.44
			c33.874,0,61.44-27.566,61.44-61.44C491.622,396.262,464.056,368.696,430.182,368.696z M430.182,450.616
			c-11.305,0-20.48-9.195-20.48-20.48c0-11.285,9.175-20.48,20.48-20.48s20.48,9.196,20.48,20.48S441.487,450.616,430.182,450.616z"
        />
	</g>
</g>
<g>
	<g>
		<path d="M418.693,247.405c-4.301-17.572-11.612-36.639-29.491-48.947l-0.082-55.071c-0.021-11.305-9.175-20.46-20.48-20.46
			h-81.818h-44.565c-2.724-7.68-7.066-14.561-12.431-20.521c9.789-10.875,15.933-25.129,15.933-40.919
			c0-33.874-27.566-61.44-61.44-61.44c-33.874,0-61.44,27.566-61.44,61.44c0,15.79,6.164,30.065,15.974,40.96
			c-9.81,10.895-15.974,25.17-15.974,40.96v122.88H102.4v-81.92c0-11.305-9.155-20.48-20.48-20.48H20.48
			c-11.325,0-20.48,9.175-20.48,20.48v102.4v102.298c0,27.709,18.575,50.954,43.827,58.634
			c7.619,25.293,30.843,43.868,58.573,43.868c26.665,0,49.193-17.162,57.672-40.96h167.711c8.561,0,16.2-5.304,19.19-13.332
			c21.094-56.607,46.756-89.068,70.41-89.068c22.221,0,33.055,8.274,39.281,14.479c5.878,5.878,14.684,7.639,22.323,4.444
			c7.66-3.174,12.636-10.629,12.636-18.924v-12.595C491.622,291.868,460.186,255.331,418.693,247.405z M102.4,450.608
			c-11.305,0-20.48-9.175-20.48-20.48c0-11.284,9.175-20.48,20.48-20.48s20.48,9.196,20.48,20.48
			C122.88,441.433,113.705,450.608,102.4,450.608z M199.311,348.207c3.625-11.407,5.489-23.265,5.489-35.267
			c0-21.75-16.548-41.165-39.404-46.162c-0.512-0.123-1.024-0.205-1.556-0.287V143.407c0-11.284,9.175-20.48,20.48-20.48
			s20.48,9.195,20.48,20.48c0,11.325,9.155,20.48,20.48,20.48h41.062v20.48h-61.44c-11.325,0-20.48,9.175-20.48,20.48v40.96
			c0,11.325,9.155,20.48,20.48,20.48l21.361,1.495l30.72,80.425H199.311z M286.822,311.569l-21.852-57.201
			c-5.427-17.326-21.238-29-39.588-29.041h61.44V311.569z"/>
	</g>
</g>
</svg>
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
