@extends('layout.master')
@section('content')
    <input type="hidden" value="{{getConstantByKey($constants,'ratio')->value}}" id="ratio">
    <input type="hidden" value="{{getConstantByKey($constants,'fix_amount')->value}}" id="fix_amount">
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
                            <a href="javascript:void(0)" id="trip_create_btn" type="button"
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
                                    id="delete_selected">الغاء المحدد
                            </button>
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
                            <button type="button" class="btn btn-success"
                                    data-kt-customer-table-select="complete_selected"
                                    id="complete_selected">اكمال الرحلات المحددة
                            </button>
                        </div>
                        <!--end::Group actions-->
                    </div>
                    <!--end::Card toolbar-->
                    <!--begin::Advance form-->
                    <div class="collapse show" id="kt_advanced_search_form">
                        <!--begin::Separator-->
                        <div class="separator separator-dashed mt-0 mb-0"></div>
                        <!--end::Separator-->
                        <div class="row g-8 mb-3 mt-1" id="totals">
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
                                        <option value="{{\App\Constants\Enum::PENDING}}">غير مكتملة</option>
                                        <option value="{{\App\Constants\Enum::COMPLETED}}">مكتملة</option>
                                        <option value="{{\App\Constants\Enum::CANCELED}}">ملغية</option>

                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-3 mt-1">
                                    <label class="form-label fs-5 fw-bold ">من</label>

                                    <input type="text" class="form-control form-control-solid" id="date_from"
                                           placeholder="اختر التاريخ  و الوقت">


                                </div>
                                <div class="col-lg-3 mt-1">
                                    <label class="form-label fs-5 fw-bold ">الى</label>

                                    <input type="text" class="form-control form-control-solid" id="date_to"
                                           placeholder="اختر التاريخ  و الوقت">

                                </div>
                                <div class="col-lg-3 mt-1">
                                    <div class="row mt-8">
                                        <div class="col-lg-6">
                                            <button id="prev_day" data-type="prev" data-id="{{$start_end_time->id}}"
                                                    type="button"
                                                    class="btn btn-primary">اليوم السابق
                                            </button>
                                        </div>
                                        <div class="col-lg-6">
                                            <button id="next_day" data-type="next" data-id="{{$start_end_time->id}}"
                                                    type="button"
                                                    class="btn btn-info">اليوم التالي
                                            </button>
                                        </div>
                                    </div>


                                </div>

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
                                    <input class="form-check-input" id="all_checked" type="checkbox"
                                           data-kt-check="true"
                                           data-kt-check-target="#kt_customers_table .form-check-input" value="1"/>
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

    @include('trips.partial.modal')
@endsection
@section('scripts')

    <script>
        var dt;
        $(document).ready(function () {
            "use strict";
            // $.fn.modal.Constructor.prototype.enforceFocus = function() {};
            // $('#date_from').attr('disabled',true)
            $(document).on('select2:open', '.form-select', function() {

                $('.select2-search__field').each(function (){
                    $(this)[0].focus()
                })


            });
            function showTotalsDiv() {
                var status = $('#status_filter');
                var captain = $('#captain_filter');
                var date_from = $('#date_from');
                var date_to = $('#date_to');
                return (status && (status.val() == 'pending' || status.val() == 'completed'))
                    && (captain && captain.val()) &&
                    (date_from && date_from.val());
            }

            // Class definition
            var KTDatatablesServerSide = function () {
                // Shared variables
                var table;

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
                        'lengthMenu': [[50, 70, 100, 200, -1], [50, 70, 100, 200, 'الكل']],
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

                            var TotalAmountAfterDiscountForOffice = totalAmount ? ((totalAmount * ratio) + parseFloat(fix_amount)) : 0;
                            var decimalPart = TotalAmountAfterDiscountForOffice - Math.floor(TotalAmountAfterDiscountForOffice);
                            if (decimalPart >= 0.44) {
                                TotalAmountAfterDiscountForOffice = Math.floor(TotalAmountAfterDiscountForOffice) + 1
                            } else {
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
                            if (data.is_success_row) {
                                $(row).addClass('success_row');
                            } else if (data.is_primary_row) {
                                $(row).addClass('primary_row');
                            } else if (data.is_warning_row) {
                                $(row).addClass('warning_row');
                            } else if (data.is_danger_row) {
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
                            if (showTotalsDiv()) {
                                $('#totals').show()
                            } else {
                                $('#totals').hide()
                            }



                            if(filterId == '#date_from'){
                                searchParams[column] = $(this).val().toLowerCase().toLowerCase();
                                if($('#date_to').val()){
                                    searchParams['date_to'] = $('#date_to').val().toLowerCase().toLowerCase();
                                }else{
                                    delete searchParams['date_to'];
                                }
                            }else{
                                searchParams[column] = $(this).val().toLowerCase().toLowerCase();
                            }
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
                    addSearchParam('#date_from', 'date_from');
                    addSearchParam('#date_to', 'date_to');

                    var id = null;
                    var amount = null;
                    var from = null;
                    var to = null;
                    $(document).on('dblclick', '.amount', function (e) {
                        amount = $(this).data('amount')
                        id = $(this).data('id')
                        $('#amount').val(amount)
                        $('#update_amount_modal').modal('show')
                    });


                    $('#submit').click(function () {
                        disableButton('submit')
                        var amount = $('#amount').val()
                        if (parseInt(amount) && id) {
                            axios.post('{{route('trips.update_price')}}', {
                                'id': id,
                                'amount': amount
                            }).then(function (response) {
                                dt.draw();
                                id = null;
                                amount = null
                                $('#update_amount_modal').modal('hide')
                                enableButton('submit')

                            }).catch(function (error) {

                                if (error.response && error.response.status === 401 && error.response.data.message === 'Unauthenticated.') {
                                    window.location.reload();
                                } else if (error.response && error.response.status === 419) {
                                    window.location.reload();
                                } else {
                                    enableButton('submit')
                                }
                            });
                        } else {
                            alert("السعر مطلوب")
                            enableButton('submit')
                        }

                    })
                    $('#cancel').click(function () {
                        $('#update_amount_modal').modal('hide')
                        id = null;
                        amount = null
                    })


                    $(document).on('dblclick', '.from', function (e) {
                        from = $(this).data('from')
                        id = $(this).data('id')
                        $('#from').html(from)
                        $('#update_from_modal').modal('show')
                    });


                    $('#submit_from').click(function () {
                        disableButton('submit_from')
                        from = $('#from').val()
                        if (from && id) {
                            axios.post('{{route('trips.update_from')}}', {
                                'id': id,
                                'from': from
                            }).then(function (response) {
                                dt.draw();
                                id = null;
                                from = null
                                $('#update_from_modal').modal('hide')
                                enableButton('submit_from')
                            }).catch(function (error) {
                                if (error.response && error.response.status === 401 && error.response.data.message === 'Unauthenticated.') {
                                    window.location.reload();
                                } else if (error.response && error.response.status === 419) {
                                    window.location.reload();
                                } else {
                                    enableButton('submit_from')
                                }
                            });
                        } else {
                            alert("أدخل الحقل")
                            enableButton('submit_from')
                        }

                    })
                    $('#cancel_from').click(function () {
                        $('#update_from_modal').modal('hide')
                        id = null;
                        from = null
                    })


                    $(document).on('dblclick', '.to', function (e) {
                        to = $(this).data('to')
                        id = $(this).data('id')
                        $('#to').html(to)
                        $('#update_to_modal').modal('show')
                    });


                    $('#submit_to').click(function () {
                        disableButton('submit_to')

                        to = $('#to').val()
                        if (to && id) {
                            axios.post('{{route('trips.update_to')}}', {'id': id, 'to': to}).then(function (response) {
                                dt.draw();
                                id = null;
                                to = null
                                $('#update_to_modal').modal('hide')
                                enableButton('submit_to')
                            }).catch(function (error) {
                                if (error.response && error.response.status === 401 && error.response.data.message === 'Unauthenticated.') {
                                    window.location.reload();
                                } else if (error.response && error.response.status === 419) {
                                    window.location.reload();
                                } else {
                                    enableButton('submit_to')
                                }
                            });
                        } else {
                            alert("أدخل الحقل")
                            enableButton('submit_to')
                        }

                    })
                    $('#cancel_to').click(function () {
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
                    completeSelected.addEventListener('click', function () {
                        var captain_id = $('#captain_filter').val();
                        if (!captain_id) {
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
                        // disableButton('complete_selected')

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
                                        },

                                    }).then(function () {
                                        const ids = [];
                                        const headerCheck = container.querySelectorAll('[type="checkbox"]');
                                        headerCheck.forEach((element) => {
                                            if (element.checked == true)
                                                ids.push(parseInt($(element).val()));
                                        });
                                        var completed_at = $('#date').val()
                                        // delete row data from server and re-draw datatable
                                        axios.post('{{route('trips.complete_selected')}}', {
                                            'ids': ids,
                                            'captain_id': captain_id
                                        }).then(function (response) {
                                            dt.draw();
                                            // enableButton('complete_selected')

                                        }).catch(function (error) {
                                            if (error.response && error.response.status === 401 && error.response.data.message === 'Unauthenticated.') {
                                                window.location.reload();
                                            } else if (error.response && error.response.status === 419) {
                                                window.location.reload();
                                            }
                                        });
                                    });

                                    // Remove header checked box

                                    const headerCheckbox = container.querySelectorAll('[type="checkbox"]')[0];

                                    headerCheckbox.checked = false;
                                    // enableButton('complete_selected')
                                });
                            } else if (result.dismiss === 'cancel') {
                                // enableButton('complete_selected')
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
                                            if (element.checked == true)
                                                ids.push(parseInt($(element).val()));
                                        });
                                        // delete row data from server and re-draw datatable
                                        axios.post('{{route('trips.cancel_selected')}}', {'ids': ids})
                                            .then(function (response) {
                                                dt.draw();
                                            }).catch(function (error) {
                                            if (error.response && error.response.status === 401 && error.response.data.message === 'Unauthenticated.') {
                                                window.location.reload();
                                            } else if (error.response && error.response.status === 419) {
                                                window.location.reload();
                                            }
                                        });
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
                                            }).catch(function (error) {
                                                if (error.response && error.response.status === 401 && error.response.data.message === 'Unauthenticated.') {
                                                    window.location.reload();
                                                } else if (error.response && error.response.status === 419) {
                                                    window.location.reload();
                                                }
                                            });

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

            // Class definition

            $('#totals').hide()

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

            $("#date").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1901,
                maxYear: parseInt(moment().format("YYYY"), 12)
            });
            flatpickr("#date_from", {
                enableTime: true, // Enables time selection along with the date
                dateFormat: "Y-m-d H:i", // Customize the date and time format
            });
            flatpickr("#date_to", {
                enableTime: true, // Enables time selection along with the date
                dateFormat: "Y-m-d H:i", // Customize the date and time format
            });


        });

    </script>

    <script>
        $(document).ready(function () {
            toastr.options = {
                "positionClass": "toast-top-left",
            }


            $('#trip_create_btn').click(function () {
                $('#trip_create_modal').modal('show')
                {{--var url = '{{route('trips.get-available-captains')}}';--}}
                {{--axios.get(url).then(function (response) {--}}
                {{--    var captains = response.data.data.captains;--}}
                {{--    addOptions(captains);--}}

                {{--})--}}
            })
            $('.close_trip_create_modal').click(function () {
                clearInputs()
                $('#trip_create_modal').modal('hide')
            })

            function addOptions(options) {
                var selectElement = $('#captain_select2').select2();
                const selectData = options.map(option => ({
                    id: option.id,
                    text: option.name + ' - ' + option.phone,
                }));
                selectElement.empty();
                selectData.unshift({id: '', text: ''});

                selectElement.select2({
                    data: selectData
                });

                $(".select-modal").select2({
                    dropdownParent: $("#trip_create_modal")
                })


            }


            $('#trip_create_submit').click(function () {
                if (validations()) {
                    enableButton('trip_create_submit')
                    return;
                }

                const owner = $('input[name="owner"]:checked').val();
                const customer_id = $('#customer_select2').val()
                const place_id = $('#place_select2').val()
                const captain_id = $('#captain_select2').val()
                const amount = $('#amount_trip_modal').val()
                const from = $('#from_trip_modal').val()
                const to = $('#to_trip_modal').val()
                const status = $('input[name="status"]:checked').val();
                var customer_name = $('#customer_name').val()
                var customer_phone = $('#customer_phone').val()
                var place_name = $('#place_name').val()
                var place_phone = $('#place_phone').val()
                var add_or_cancel_customer_value = $('#add-or-cancel-customer').val()
                var add_or_cancel_place_value = $('#add-or-cancel-place').val()
                var body = {
                    owner: owner,
                    customer_id: customer_id,
                    place_id: place_id,
                    captain_id: captain_id,
                    amount: amount,
                    from: from,
                    to: to,
                    customer_name: customer_name,
                    customer_phone: customer_phone,
                    place_name: place_name,
                    place_phone: place_phone,
                    add_or_cancel_customer_value: add_or_cancel_customer_value,
                    add_or_cancel_place_value: add_or_cancel_place_value,
                }

                axios.post('{{route('trips.ajax_store')}}', body).then(function (response) {
                    if (response.data.status) {
                        clearInputs()
                        dt.draw()
                        $('#trip_create_modal').modal('hide')
                        $('#trip_create_btn').click()
                        toastr.success(response.data.msg)
                        enableButton('trip_create_submit')
                    } else {
                        toastr.error(response.data.msg)
                        enableButton('trip_create_submit')
                    }
                }).catch(function (error) {
                    if (error.response && error.response.status === 401 && error.response.data.message === 'Unauthenticated.') {
                        window.location.reload();
                    } else if (error.response && error.response.status === 419) {
                        window.location.reload();
                    }
                });


            })


            function clearInputs() {
                $('#captain_select2').val('')
                $('#place_select2').val('')
                $('#customer_select2').val('')
                $('#amount_trip_modal').val('')
                $('#from_trip_modal').val('');
                $('#to_trip_modal').val('')


                $('#place_radio_btn').prop('checked', true);
                $('#place-label').addClass('active')
                $('#customer_radio_btn').prop('checked', false);
                $('#customer-label').removeClass('active')


                $('#customer').hide();
                $('#place').show();



                $('#customer_name').val('')
                $('#customer_phone').val('')
                $('#place_name').val('')
                $('#place_phone').val('')


                toggleCancelAddCustomer()
                toggleCancelAddPlace()


                // $('#pending_status').prop('checked', true);

            }

            function validations() {
                var flag = false;

                const selectedValue = $('input[name="owner"]:checked').val();
                const customer_select2 = $('#customer_select2').val()
                const add_or_cancel_customer_value = $('#add-or-cancel-customer').val()
                const add_or_cancel_place_value = $('#add-or-cancel-place').val()
                const place_select2 = $('#place_select2').val()
                const captain_select2 = $('#captain_select2').val()
                if ((add_or_cancel_customer_value && add_or_cancel_customer_value == 1) && selectedValue === 'customer' && false) {
                    if (!customer_select2) {
                        toastr.warning("اختر زبون");
                        flag = true
                    }
                } else if ((add_or_cancel_customer_value && add_or_cancel_customer_value == 2) && selectedValue === 'customer' && false) {
                    const customer_name = $('#customer_name').val()
                    const customer_phone = $('#customer_phone').val()
                    if (!customer_name) {
                        toastr.warning(" أدخل اسم الزبون");
                        flag = true
                    }
                    if (!customer_phone) {
                        toastr.warning(" أدخل جوال الزبون");
                        flag = true
                    }
                } else if ((add_or_cancel_place_value && add_or_cancel_place_value == 1) && selectedValue === 'place' && false) {
                    if (!place_select2) {
                        toastr.warning("اختر مكان");
                        flag = true
                    }
                } else if ((add_or_cancel_place_value && add_or_cancel_place_value == 2) && selectedValue === 'place' && false) {
                    const place_name = $('#place_name').val()
                    const place_phone = $('#place_phone').val()
                    if (!place_name) {
                        toastr.warning(" أدخل اسم المكان");
                        flag = true
                    }
                    if (!place_phone) {
                        toastr.warning(" أدخل جوال المكان");
                        flag = true
                    }
                }

                if (!captain_select2) {
                    toastr.warning(" اختر كابتن");
                    flag = true
                }
                return flag;
            }


            $('#trip_create_modal').on('shown.bs.modal', function (e) {
                $(".select-modal").select2({
                    dropdownParent: $("#trip_create_modal")
                })
                clearInputs()



            })


            //----------------------------------




            $('input[name="owner"]').on('change', function () {
                var selectedValue = $(this).val();
                if (selectedValue === 'customer') {
                    $('#place').hide();
                    $('#customer').show();

                    toggleCancelAddCustomer()
                    toggleCancelAddPlace()

                } else if (selectedValue === 'place') {
                    $('#customer').hide();
                    $('#place').show();
                    $('#add_customer_form').addClass('d-none')
                    toggleCancelAddPlace()
                }
            });
            $('#place_select2').on('change', function () {
                var modal = document.getElementById('trip_create_modal');
                var textarea = modal.querySelector('#from_trip_modal');
                textarea.value = $('#place_address_' + $(this).val()).val();
            });

            // $('#place_radio_btn').prop('checked', true);
            // $('#customer').hide();


            $('#add_customer').click(function (e) {
                e.preventDefault()
                if($('#add-or-cancel-place').val() == 2){
                    return;
                }
                    toggleAddCustomer()
            })

            $('#cancel_add_customer').click(function (e) {
                e.preventDefault()
                toggleCancelAddCustomer()
            })

            $('#add_place').click(function (e) {
                e.preventDefault()
                toggleAddPlace()
            })

            $('#cancel_add_place').click(function (e) {
                e.preventDefault()
                toggleCancelAddPlace()
            })





            $('#date_from').val('{{$start_end_time->start_time}}')
            $('#date_from').change()
            $('#date_from').attr('disabled', true)


            $('#date_to').attr('disabled', true)
            $('#next_day').attr('disabled', true)


            $('#prev_day').click(function () {
                var date_to = null;
                var date_from = null;
                var id = $(this).data('id');
                var url = '{{route('start_time.day')}}';
                url = url + `?id=${id}&type=prev`
                axios.get(url).then(function (response) {
                    if (response.data.status) {
                        var item = response.data.data.item;
                        if (response.data.data.item) {
                            $('#date_from').val('')
                            $('#date_to').val('')

                            $('#next_day').attr('disabled', false)
                            $('#prev_day').data("id", item.id);
                            $("#next_day").data("id", item.id);
                            $('#date_from').val(item.start_time)
                             date_from = $('#date_from').val()


                            if(item.end_time){
                                $('#date_to').val(item.end_time)
                                date_to = $('#date_to').val()
                            }



                            if (date_from && date_to) {
                                $('#date_from').change();
                                $('#date_to').change();
                            } else if (date_from) {
                                $('#date_from').change();
                            }

                        } else {
                            $('#prev_day').attr('disabled', true)
                        }

                    }
                }).catch(function (error) {
                    if (error.response && error.response.status === 401 && error.response.data.message === 'Unauthenticated.') {
                        window.location.reload();
                    } else if (error.response && error.response.status === 419) {
                        window.location.reload();
                    }
                });
            })

            $('#next_day').click(function () {
                var date_to = null;
                var date_from = null;
                var id = $(this).data('id');
                var url = '{{route('start_time.day')}}';
                url = url + `?id=${id}&type=next`
                axios.get(url).then(function (response) {
                    if (response.data.status) {

                        var item = response.data.data.item;
                        if (item) {
                            $('#date_from').val('')
                            $('#date_to').val('')


                            $('#prev_day').attr('disabled', false)
                            $('#prev_day').data("id", item.id);
                            $("#next_day").data("id", item.id);


                            $('#date_from').val(item.start_time)
                             date_from = $('#date_from').val()



                            if(item.end_time){
                                $('#date_to').val(item.end_time)
                                date_to = $('#date_to').val()
                            }







                            if (date_from && date_to) {
                                $('#date_from').change();
                                $('#date_to').change();
                            } else if (date_from) {
                                $('#date_from').change();
                            }
                        } else {
                            $('#next_day').attr('disabled', true)
                            $('#prev_day').attr('disabled', false)
                        }

                    }
                }).catch(function (error) {
                    if (error.response && error.response.status === 401 && error.response.data.message === 'Unauthenticated.') {
                        window.location.reload();
                    } else if (error.response && error.response.status === 419) {
                        window.location.reload();
                    }
                });
            })

            function toggleCancelAddCustomer() {
                $('#exist-customer-section').removeClass('d-none')
                $('#add_customer').removeClass('d-none')

                $('#add_customer_form').addClass('d-none')
                $('#cancel_add_customer').addClass('d-none')
                $('#add-or-cancel-customer').val(1)
            }

            function toggleCancelAddPlace() {
                $('#exist-place-section').removeClass('d-none')
                $('#add_place').removeClass('d-none')

                $('#add_place_form').addClass('d-none')
                $('#cancel_add_place').addClass('d-none')
                $('#add-or-cancel-place').val(1)
            }

            function toggleAddCustomer() {
                $('#exist-customer-section').addClass('d-none')
                $('#add_customer').addClass('d-none')
                $('#add_customer_form').removeClass('d-none')
                $('#cancel_add_customer').removeClass('d-none')
                $('#add-or-cancel-customer').val(2)
            }

            function toggleAddPlace() {
                $('#exist-place-section').addClass('d-none')
                $('#add_place').addClass('d-none')
                $('#add_place_form').removeClass('d-none')
                $('#cancel_add_place').removeClass('d-none')
                $('#add-or-cancel-place').val(2)
            }

        });


    </script>



@endsection
