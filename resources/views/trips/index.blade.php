@extends('layout.master')
@section('content')
    <input type="hidden"  value="{{getConstantByKey($constants,'ratio')->value}}" id="ratio">
    <input type="hidden"  value="{{getConstantByKey($constants,'fix_amount')->value}}" id="fix_amount">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header border-0">
                    <!--begin::Card title-->

                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1"></div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">

                            <!--end::Filter-->
                            <!--begin::Add customer-->
                            <a href="{{route('trips.create')}}" type="button"
                               class="btn btn-primary">{{__('lang.add')}}</a>
                            <!--end::Add customer-->
                        </div>
                        <!--end::Toolbar-->
                        <!--begin::Group actions-->
                        <div class="d-flex justify-content-end align-items-center d-none"
                             data-kt-customer-table-toolbar="selected">
                            <div class="fw-bolder me-5">
                                <span class="me-2"
                                      data-kt-customer-table-select="selected_count"></span>{{__('lang.selected')}}
                            </div>
                            <button type="button" class="btn btn-danger" data-kt-customer-table-select="delete_selected"
                                    id="delete_selected">الغاء المحدد</button>
                        </div>
                        <!--end::Group actions-->
                        <!--begin::Group actions-->
{{--                        <div class="d-flex justify-content-end align-items-center d-none"--}}
{{--                             data-kt-customer-table-toolbar="closed_selected">--}}
{{--                            <div class="fw-bolder me-5">--}}
{{--                            </div>--}}
{{--                            <button type="button" class="btn btn-primary" data-kt-customer-table-select="closed_selected"--}}
{{--                                    id="closed_selected"> اغلاق الرحلات الغير مدخلة</button>--}}
{{--                        </div>--}}
                        <!--end::Group actions-->
                        <!--begin::Group actions-->
                        <div class="d-flex justify-content-end align-items-center d-none"
                             data-kt-customer-table-toolbar="complete_selected">
                            <div class="fw-bolder me-5">

                            </div>
                            <button type="button" class="btn btn-success" data-kt-customer-table-select="complete_selected"
                                    id="complete_selected">اكمال الرحلات المحددة</button>
                        </div>
                        <!--end::Group actions-->
                    </div>
                    <!--end::Card toolbar-->
                    <!--begin::Advance form-->
                    <div class="collapse show" id="kt_advanced_search_form">
                        <!--begin::Separator-->
                        <div class="separator separator-dashed mt-0 mb-0"></div>
                        <!--end::Separator-->
                        <div class="row g-8 mb-3 mt-1">
                            <div class="col-lg-4">
                                <div id="totalAmount"></div>
                            </div>
                            <div class="col-lg-4">
                                <div id="totalAmountAfterDiscount"></div>
                            </div>
                            <div class="col-lg-4">
                                <div id="totalAmountAfterDiscountForOffice"></div>
                            </div>
                        </div>
                        <!--begin::Separator-->
                        <div class="separator separator-dashed mt-0 mb-0"></div>
                        <!--end::Separator-->
                        <!--begin::Row-->
                        <div class="row g-8 mb-3 mt-1">
                            <!--begin::Row-->
                            <div class="row g-8 academic-dev">
                                <!--begin::Col-->
                                <div class="col-lg-3 mt-1">
                                    <!--begin::Label-->
                                    <label class="form-label fs-5 fw-bold ">أماكن</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-select form-select-solid  w-250px fw-bolder "
                                            data-kt-select2="true" data-placeholder="{{__('lang.select')}}"
                                            data-allow-clear="true" id="place_filter">
                                        <option></option>
                                        @foreach($places as $place)
                                            <option value="{{$place->id}}">{{$place->name}}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-3 mt-1">
                                    <!--begin::Label-->
                                    <label class="form-label fs-5 fw-bold ">زبائن</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-select form-select-solid  w-250px fw-bolder "
                                            data-kt-select2="true" data-placeholder="{{__('lang.select')}}"
                                            data-allow-clear="true" id="customer_filter">
                                        <option></option>
                                        @foreach($customers as $customer)
                                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-3 mt-1">
                                    <!--begin::Label-->
                                    <label class="form-label fs-5 fw-bold ">كباتن</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-select form-select-solid  w-250px fw-bolder "
                                            data-kt-select2="true" data-placeholder="{{__('lang.select')}}"
                                            data-allow-clear="true" id="captain_filter">
                                        <option></option>
                                        @foreach($captains as $captain)
                                            <option value="{{$captain->id}}">{{$captain->name}}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->

                                <!--begin::Col-->
                                <div class="col-lg-3 mt-1">
                                    <!--begin::Label-->
                                    <label class="form-label fs-5 fw-bold ">مغلقة/مفتوحة</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-select form-select-solid w-250px fw-bolder "
                                            data-kt-select2="true" data-placeholder="{{__('lang.select')}}"
                                            data-allow-clear="true" id="open_close_filter">
                                        <option></option>
                                        <option value="closed">مغلقة</option>
                                        <option value="open">غير مدخلة</option>

                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-3 mt-1">
                                    <!--begin::Label-->
                                    <label class="form-label fs-5 fw-bold ">{{__('lang.Status')}}:</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-select form-select-solid w-250px fw-bolder status_filter"
                                            data-kt-select2="true" data-placeholder="{{__('lang.select')}}"
                                            data-allow-clear="true" id="status_filter">
                                        <option></option>
                                        <option value="{{\App\Constants\Enum::PENDING}}">غير مكتملة </option>
                                        <option value="{{\App\Constants\Enum::COMPLETED}}">مكتملة</option>
                                        <option value="{{\App\Constants\Enum::CANCELED}}">ملغية</option>

                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-3 mt-1">
                                    <!--begin::Label-->
                                    <label class="form-label fs-5 fw-bold ">التاريخ</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-solid" placeholder="اختر التاريخ" id="date"/>

                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
{{--                                <div class="col-lg-3 mt-1">--}}
{{--                                    <!--begin::Label-->--}}
{{--                                    <label class="form-label fs-5 fw-bold ">إلى</label>--}}
{{--                                    <!--end::Label-->--}}
{{--                                    <!--begin::Input-->--}}
{{--                                    <input class="form-control form-control-solid" placeholder="اختر التاريخ" id="date_to"/>--}}

{{--                                    <!--end::Input-->--}}
{{--                                </div>--}}
                                <!--end::Col-->

                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Advance form-->
                    <!--begin::Card title-->

                </div>
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="datatable">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" id="all_checked" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_customers_table .form-check-input" value="1" />
                                </div>
                            </th>
                            <th class="min-w-125px">صاحب الطلب</th>
                            <th class="min-w-125px"> الكابتن</th>
                            <th class="min-w-125px"> من</th>
                            <th class="min-w-125px"> الى</th>
                            <th class="min-w-125px"> السعر</th>
                            <th class="min-w-125px"> التاريخ</th>
                            <th class="min-w-125px"> الحالة</th>
                            <th class="text-end min-w-70px">{{__('lang.actions')}}</th>
                        </tr>
                        <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-bold text-gray-600">


                        </tbody>
                        <!--end::Table body-->

                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
    <div class="modal" id="update_amount_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                </div>
                <!-- Modal body -->
                <div class="modal-body" style="text-align: center" >
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
                    <button type="button" id="cancel" class="btn btn-danger" >الغاء</button>
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
                <div class="modal-body" style="text-align: center" >
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
                            <textarea name="from" id="from"  class="form-control mb-2"></textarea>
                            <!--end::Input-->
                        </div>
                        <!--begin::Col-->
                    </div>
                    <!--begin::Separator-->
                    <div class="separator separator-dashed mt-6 mb-6"></div>

                </div>
                <div class="modal-footer" style="justify-content:center">
                    <button type="button" id="submit_from" class="btn btn-primary">تعديل</button>
                    <button type="button" id="cancel_from" class="btn btn-danger" >الغاء</button>
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
                <div class="modal-body" style="text-align: center" >
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
                            <textarea name="to" id="to"  class="form-control mb-2"></textarea>
                            <!--end::Input-->
                        </div>
                        <!--begin::Col-->
                    </div>
                    <!--begin::Separator-->
                    <div class="separator separator-dashed mt-6 mb-6"></div>

                </div>
                <div class="modal-footer" style="justify-content:center">
                    <button type="button" id="submit_to" class="btn btn-primary">تعديل</button>
                    <button type="button" id="cancel_to" class="btn btn-danger" >الغاء</button>
                </div>
            </div>
            <!-- Modal footer -->
        </div>
    </div>
@endsection
@section('scripts')

    <script>

        // $("#datatable").DataTable();
        "use strict";

        // Class definition
        var KTDatatablesServerSide = function () {
            // Shared variables
            var table;
            var dt;
            var filterPayment;

            // Private functions
            var initDatatable = function () {
                dt = $("#datatable").DataTable({
                    language: {
                        url: '{{asset('datatable.json')}}',
                    },
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    'pagingType': 'full_numbers',
                    'lengthMenu': [[10,20, 30, 40, -1], [10, 20, 30, 40, 'الكل']],
                    order: [6, 'desc'],
                    stateSave: false,
                    select: {
                        style: 'multi',
                        selector: 'td:first-child input[type="checkbox"]',
                        className: 'row-selected'
                    },
                    ajax: {
                        // url: "https://preview.keenthemes.com/api/datatables.php",
                        url: "{{route('trips.index')}}",
                    },
                    columns: [
                        {data: 'id'},
                        {data: 'owner_name'},
                        {data: 'captain_name'},
                        {data: 'from'},
                        {data: 'to'},
                        {data: 'amount'},
                        {data: 'created_at'},
                        {data: 'status'},
                        {data: 'actions'},
                    ],
                    columnDefs: [

                        {
                            targets: 0,
                            orderable: false,
                            lassName: 'text-start',
                        },
                        {
                            targets: 1,
                            orderable: false,

                        },
                        {
                            targets: 2,
                            orderable: false,
                        },

                        {
                            targets: 3,
                            orderable: false,

                        },
                        {
                            targets: 4,
                            orderable: false,

                        },
                        {
                            targets: -1,
                            orderable: false,
                            className: 'text-end',
                        },
                    ],
                    footerCallback: function (row, data, start, end, display) {
                        var TotalAmountIndex = 5;
                        var ratio = $('#ratio').val();
                        var fix_amount = $('#fix_amount').val();
                        var TotalAmountAfterDiscount = 0

                        var api = this.api();

                        // Remove the formatting to get integer data for summation
                        var intVal = function (i) {
                            return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
                        };

                        // Calculate the sum of the price column (index 4)
                        var totalAmount = api
                            .column(TotalAmountIndex, {search: 'applied'})
                            .data()
                            .reduce(function (accumulator, currentValue) {
                                var value = parseInt($(currentValue).text(), 10);
                                if (!isNaN(value)) {
                                    return accumulator + value;
                                } else {
                                    return accumulator;
                                }
                            }, 0);

                        var TotalAmountAfterDiscountForOffice = totalAmount? ((totalAmount*ratio)+parseFloat(fix_amount)) : 0;
                        var decimalPart = TotalAmountAfterDiscountForOffice - Math.floor(TotalAmountAfterDiscountForOffice);
                        if(decimalPart >=0.44){
                            TotalAmountAfterDiscountForOffice = Math.floor(TotalAmountAfterDiscountForOffice) + 1
                        }else{
                            TotalAmountAfterDiscountForOffice = Math.floor(TotalAmountAfterDiscountForOffice)

                        }
                        TotalAmountAfterDiscount = totalAmount - TotalAmountAfterDiscountForOffice;

                        // Update the sum in the footer row
                        var html1 = ` <div style="color: red;"> الــمـجـمـوع الكـلـي  : <span class="totalAmount" style="font-size: 20px;color: red;">${totalAmount.toFixed(1)} &#8362;</span> </div>`
                        var html2 = `<div style="color: red;">المجموع بعد الخصم: <span class="totalAmount" style="font-size: 20px;color: red;">${TotalAmountAfterDiscount.toFixed(1)} &#8362;</span></div>`
                        var html3 = `<div style="color: red;">  المبلغ المستحق: <span class="totalAmount" style="font-size: 20px;color: red;">${TotalAmountAfterDiscountForOffice.toFixed(1)} &#8362;</span></div>`


                        $('#totalAmount').html(html1)
                        $('#totalAmountAfterDiscount').html(html2)
                        $('#totalAmountAfterDiscountForOffice').html(html3)
                    },
                    rowCallback: function (row, data) {
                        if (data.status_str === 'completed') {
                            $(row).addClass('success_row');
                        }else if(data.status_str === 'pending' && data.amount_str){
                            $(row).addClass('primary_row');
                        }else if(data.status_str === 'pending' && !data.amount_str){
                            $(row).addClass('warning_row');
                        }else if(data.status_str === 'canceled'){
                            $(row).addClass('danger_row');
                        }
                    }
                });

                table = dt.$;

                dt.on('draw', function () {
                    handleDeleteRows();
                    initToggleToolbar();
                    KTMenu.createInstances();
                    toggleToolbars();
                });


            }

            var handleSearchDatatable = function () {
                var searchParams = {};

                // Function to add search parameter to the searchParams object
                function addSearchParam(filterId, column) {
                    $(filterId).change(function () {
                        searchParams[column] = $(this).val().toLowerCase();
                        dt.search(JSON.stringify(searchParams)).draw();
                    });
                }

                // const filterSearch = document.querySelector('#search');
                // filterSearch.addEventListener('keyup', function (e) {
                //     dt.search(e.target.value,'search').draw();
                // });

                addSearchParam('#status_filter', 'status');
                addSearchParam('#customer_filter', 'customer_id');
                addSearchParam('#captain_filter', 'captain_id');
                addSearchParam('#place_filter', 'place_id');
                addSearchParam('#open_close_filter', 'open_close');
                addSearchParam('#date', 'date');
                // addSearchParam('#date_to', 'date_to');

                var id = null;
                var amount = null;
                var from = null;
                var to = null;
                $(document).on('dblclick','.amount',function (e) {
                     amount = $(this).data('amount')
                    id = $(this).data('id')
                    $('#amount').val(amount)
                    $('#update_amount_modal').modal('show')
                });


                $('#submit').click(function (){
                    var amount =  $('#amount').val()
                    if(amount && id){
                        axios.post('{{route('trips.update_price')}}',{'id':id,'amount':amount}).then(function (response) {
                            dt.draw();
                            id = null;
                            amount = null
                            $('#update_amount_modal').modal('hide')
                        })
                    }else{
                        alert("السعر مطلوب")
                    }

                })
                $('#cancel').click(function (){
                    $('#update_amount_modal').modal('hide')
                    id = null;
                    amount = null
                })



                $(document).on('dblclick','.from',function (e) {
                    from = $(this).data('from')
                    id = $(this).data('id')
                    $('#from').html(from)
                    $('#update_from_modal').modal('show')
                });


                $('#submit_from').click(function (){
                     from =  $('#from').val()
                    if(from && id){
                        axios.post('{{route('trips.update_from')}}',{'id':id,'from':from}).then(function (response) {
                            dt.draw();
                            id = null;
                            from = null
                            $('#update_from_modal').modal('hide')
                        })
                    }else{
                        alert("أدخل الحقل")
                    }

                })
                $('#cancel_from').click(function (){
                    $('#update_from_modal').modal('hide')
                    id = null;
                    from = null
                })


                $(document).on('dblclick','.to',function (e) {
                    to = $(this).data('to')
                    id = $(this).data('id')
                    $('#to').html(to)
                    $('#update_to_modal').modal('show')
                });


                $('#submit_to').click(function (){
                    to =  $('#to').val()
                    if(to && id){
                        axios.post('{{route('trips.update_to')}}',{'id':id,'to':to}).then(function (response) {
                            dt.draw();
                            id = null;
                            to = null
                            $('#update_to_modal').modal('hide')
                        })
                    }else{
                        alert("أدخل الحقل")
                    }

                })
                $('#cancel_to').click(function (){
                    $('#update_to_modal').modal('hide')
                    id = null;
                    to = null
                })

            }

            // Init toggle toolbar
            var initToggleToolbar = function () {
                // Toggle selected action toolbar
                // Select all checkboxes
                const container = document.querySelector('#datatable');
                const checkboxes = container.querySelectorAll('[type="checkbox"]');
                // Select elements
                const deleteSelected = document.querySelector('#delete_selected');
                const completeSelected = document.querySelector('#complete_selected');
                // const closedSelected = document.querySelector('#closed_selected');
                // Toggle delete selected toolbar
                checkboxes.forEach(c => {
                    // Checkbox on click event
                    c.addEventListener('click', function () {
                        setTimeout(function () {
                            toggleToolbars();
                        }, 50);
                    });
                });

                // Deleted selected rows
                completeSelected.addEventListener('click', function ()  {

                    var captain_id = $('#captain_filter').val();
                    if(!captain_id){
                        Swal.fire({
                            text: "يجب ان تختار الكابتن الذي تريد اكمال رحلاته",
                            icon: "warning",
                            buttonsStyling: false,
                            confirmButtonText: "حسنا!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        })
                        return;
                    }

                    Swal.fire({
                        text: "هل أنت متأكد أنك تريد اكمال الرحلات المختارة؟",
                        icon: "success",
                        showCancelButton: true,
                        buttonsStyling: false,
                        showLoaderOnConfirm: true,
                        confirmButtonText: "نعم ، أكمل الرحلات",
                        cancelButtonText: "لا, الغِ",
                        customClass: {
                            confirmButton: "btn fw-bold btn-success",
                            cancelButton: "btn fw-bold btn-active-light-danger"
                        },
                    }).then(function (result) {
                        if (result.value) {
                            // Simulate delete request -- for demo purpose only
                            Swal.fire({
                                text: "اكمال الرحلات المختارة",
                                icon: "info",
                                buttonsStyling: false,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function () {
                                Swal.fire({
                                    text: "لقد أكملت الرحلات المختارة",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "حسنا!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                }).then(function () {
                                    const ids = [];
                                    const headerCheck = container.querySelectorAll('[type="checkbox"]');
                                    headerCheck.forEach((element) => {
                                        if(element.checked == true)
                                            ids.push(parseInt($(element).val()));
                                    });
                                    var completed_at = $('#date').val()
                                    // delete row data from server and re-draw datatable
                                    axios.post('{{route('trips.complete_selected')}}',{'ids':ids,'completed_at':completed_at,'captain_id':captain_id}).then(function (response) {
                                        dt.draw();
                                    })
                                });

                                // Remove header checked box

                                const headerCheckbox = container.querySelectorAll('[type="checkbox"]')[0];

                                headerCheckbox.checked = false;
                            });
                        } else if (result.dismiss === 'cancel') {
                            Swal.fire({
                                text: " لقد ألغيت عملية الاكمال ",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "حسنا",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            });
                        }
                    });
                });
                {{--closedSelected.addEventListener('click', function () {--}}
                {{--    // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/--}}
                {{--    Swal.fire({--}}
                {{--        text: "هل أنت متأكد أنك تريد اغلاق الرحلات المختارة؟",--}}
                {{--        icon: "success",--}}
                {{--        showCancelButton: true,--}}
                {{--        buttonsStyling: false,--}}
                {{--        showLoaderOnConfirm: true,--}}
                {{--        confirmButtonText: "نعم ، أغلق الرحلات",--}}
                {{--        cancelButtonText: "لا, الغِ",--}}
                {{--        customClass: {--}}
                {{--            confirmButton: "btn fw-bold btn-primary",--}}
                {{--            cancelButton: "btn fw-bold btn-active-light-danger"--}}
                {{--        },--}}
                {{--    }).then(function (result) {--}}
                {{--        if (result.value) {--}}
                {{--            // Simulate delete request -- for demo purpose only--}}
                {{--            Swal.fire({--}}
                {{--                text: "اغلاق الرحلات المختارة",--}}
                {{--                icon: "info",--}}
                {{--                buttonsStyling: false,--}}
                {{--                showConfirmButton: false,--}}
                {{--                timer: 2000--}}
                {{--            }).then(function () {--}}
                {{--                Swal.fire({--}}
                {{--                    text: "لقد أغلقت الرحلات المختارة",--}}
                {{--                    icon: "success",--}}
                {{--                    buttonsStyling: false,--}}
                {{--                    confirmButtonText: "حسنا!",--}}
                {{--                    customClass: {--}}
                {{--                        confirmButton: "btn fw-bold btn-primary",--}}
                {{--                    }--}}
                {{--                }).then(function () {--}}
                {{--                    const ids = [];--}}
                {{--                    const headerCheck = container.querySelectorAll('[type="checkbox"]');--}}
                {{--                    headerCheck.forEach((element) => {--}}
                {{--                        if(element.checked == true)--}}
                {{--                            ids.push(parseInt($(element).val()));--}}
                {{--                    });--}}
                {{--                    // delete row data from server and re-draw datatable--}}
                {{--                    axios.post('{{route('trips.close_selected')}}',{'ids':ids}).then(function (response) {--}}
                {{--                        dt.draw();--}}
                {{--                    })--}}
                {{--                });--}}

                {{--                // Remove header checked box--}}

                {{--                const headerCheckbox = container.querySelectorAll('[type="checkbox"]')[0];--}}

                {{--                headerCheckbox.checked = false;--}}
                {{--            });--}}
                {{--        } else if (result.dismiss === 'cancel') {--}}
                {{--            Swal.fire({--}}
                {{--                text: " لقد ألغيت عملية الاغلاق ",--}}
                {{--                icon: "error",--}}
                {{--                buttonsStyling: false,--}}
                {{--                confirmButtonText: "حسنا",--}}
                {{--                customClass: {--}}
                {{--                    confirmButton: "btn fw-bold btn-primary",--}}
                {{--                }--}}
                {{--            });--}}
                {{--        }--}}
                {{--    });--}}
                {{--});--}}
                deleteSelected.addEventListener('click', function () {
                    // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                    Swal.fire({
                        text: "هل أنت متأكد أنك تريد الغاء الرحلات المختارة؟",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        showLoaderOnConfirm: true,
                        confirmButtonText: "نعم ، الغي الرحلات",
                        cancelButtonText: "لا, الغِ",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                            cancelButton: "btn fw-bold btn-active-light-danger"
                        },
                    }).then(function (result) {
                        if (result.value) {
                            // Simulate delete request -- for demo purpose only
                            Swal.fire({
                                text: "الغاء الرحلات المختارة",
                                icon: "info",
                                buttonsStyling: false,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function () {
                                Swal.fire({
                                    text: "لقد ألغيت الرحلات المختارة",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "حسنا!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                }).then(function () {
                                    const ids = [];
                                    const headerCheck = container.querySelectorAll('[type="checkbox"]');
                                    headerCheck.forEach((element) => {
                                        if(element.checked == true)
                                            ids.push(parseInt($(element).val()));
                                    });
                                    // delete row data from server and re-draw datatable
                                    axios.post('{{route('trips.cancel_selected')}}',{'ids':ids}).then(function (response) {
                                        dt.draw();
                                    })
                                });

                                // Remove header checked box

                                const headerCheckbox = container.querySelectorAll('[type="checkbox"]')[0];

                                headerCheckbox.checked = false;
                            });
                        } else if (result.dismiss === 'cancel') {
                            Swal.fire({
                                text: " لقد ألغيت الرحلات ",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "حسنا",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            });
                        }
                    });
                });
            }
            // Delete customer
            var handleDeleteRows = () => {
                // Select all delete buttons
                // const deleteButtons = document.querySelectorAll('[data-kt-docs-table-filter="delete_row"]');
                const deleteButtons = document.querySelectorAll('#delete_row');

                deleteButtons.forEach(d => {
                    // Delete button on click
                    d.addEventListener('click', function (e) {
                        e.preventDefault();

                        // Select parent row
                        const parent = e.target.closest('tr');
                        var record_id = $(this).data('id');
                        // Get customer name
                        const customerName = parent.querySelectorAll('td')[1].innerText;

                        // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                        Swal.fire({
                            text: "{{__('lang.Are you sure you want to delete')}} " + customerName + "?",
                            icon: "warning",
                            showCancelButton: true,
                            buttonsStyling: false,
                            confirmButtonText: "نعم, احذف!",
                            cancelButtonText: "لا, الغي",
                            customClass: {
                                confirmButton: "btn fw-bold btn-danger",
                                cancelButton: "btn fw-bold btn-active-light-primary"
                            }
                        }).then(function (result) {
                            if (result.value) {
                                // Simulate delete request -- for demo purpose only
                                Swal.fire({
                                    text: "حذفت " + customerName,
                                    icon: "info",
                                    buttonsStyling: false,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(function () {
                                    Swal.fire({
                                        text: "لقد حذفت " + customerName + "!.",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        }
                                    }).then(function () {
                                        // delete row data from server and re-draw datatable
                                        var url = '{{route("places.delete",[":id"])}}';
                                        url = url.replace(':id', record_id);

                                        axios.post(url).then(function (response) {
                                            dt.draw();
                                        })

                                    });
                                });
                            } else if (result.dismiss === 'cancel') {
                                Swal.fire({
                                    text: customerName + " لم يُحذف.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                });
                            }
                        });
                    })
                });
            }

            // Toggle toolbars
            var toggleToolbars = function () {
                // Define variables
                const container = document.querySelector('#datatable');
                const toolbarBase = document.querySelector('[data-kt-customer-table-toolbar="base"]');
                const toolbarSelected = document.querySelector('[data-kt-customer-table-toolbar="selected"]');
                const selectedCount = document.querySelector('[data-kt-customer-table-select="selected_count"]');


                const toolbarCompleteSelected = document.querySelector('[data-kt-customer-table-toolbar="complete_selected"]');
                // const toolbarClosedSelected = document.querySelector('[data-kt-customer-table-toolbar="closed_selected"]');
                const selectedCompleteCount = document.querySelector('[data-kt-customer-table-select="selected_count_completed"]');

                // Select refreshed checkbox DOM elements
                const allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');

                // Detect checkboxes state & count
                let checkedState = false;
                let count = 0;

                // Count checked boxes
                allCheckboxes.forEach(c => {
                    if (c.checked) {
                        checkedState = true;
                        count++;
                    }
                });

                // Toggle toolbars
                if (checkedState) {
                    selectedCount.innerHTML = count;
                    toolbarBase.classList.add('d-none');
                    toolbarSelected.classList.remove('d-none');

                    // selectedCompleteCount.innerHTML = count;
                    toolbarCompleteSelected.classList.remove('d-none');
                    // toolbarClosedSelected.classList.remove('d-none');
                } else {
                    toolbarBase.classList.remove('d-none');
                    toolbarSelected.classList.add('d-none');
                    toolbarCompleteSelected.classList.add('d-none');
                    // toolbarClosedSelected.classList.add('d-none');
                }
            }
            // Public methods

            return {
                init: function () {
                    initDatatable();
                    initToggleToolbar();
                    handleSearchDatatable();
                    handleDeleteRows();
                    // toggleToolbars();
                }
            }
        }();


        // On document ready
        KTUtil.onDOMContentLoaded(function () {
            KTDatatablesServerSide.init();
        });
        $(document).ready(function () {
            //set initial state.
            // $('#all_checked').val(this.checked);

            $('#all_checked').change(function () {
                const headerAllCheck = document.querySelector('#datatable').querySelectorAll('[type="checkbox"]');
                if (this.checked) {
                    headerAllCheck.forEach((element) => {
                        element.checked = true
                    });
                } else {
                    headerAllCheck.forEach((element) => {
                        element.checked = false
                    });
                }
                $('#all_checked').val(this.checked);
            });


        });

        // Class definition

    </script>
    <script>
        $(document).ready(function(){

            $("#date").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1901,
                maxYear: parseInt(moment().format("YYYY"),12)
            });
            // $("#date_to").daterangepicker({
            //     singleDatePicker: true,
            //     showDropdowns: true,
            //     minYear: 1901,
            //     maxYear: parseInt(moment().format("YYYY"),12)
            // });

        });

    </script>



@endsection
