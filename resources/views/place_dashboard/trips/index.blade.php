@extends('layout.master')
@section('content')
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header border-0 " style="display: unset">
                    <!--begin::Card title-->
                    @include('validation.alerts')
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
                            <a href="javascript:void(0)" type="button" id="request_sahm"
                               class="btn btn-primary">اطلب سهم</a>
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
                        <!--begin::Row-->
                        <div class="row g-8 mb-3 mt-1">
                            <!--begin::Row-->
                            <div class="row g-8 academic-dev">
                                <!--begin::Col-->

                                <!--end::Col-->

                                <!--begin::Col-->
                                <div class="col-lg-4 mt-1">
                                    <!--begin::Label-->
                                    <label class="form-label fs-5 fw-bold ">التاريخ</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-solid" placeholder="اختر التاريخ" id="date"/>

                                    <!--end::Input-->
                                </div>
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
                            <th class="min-w-125px"> التاريخ</th>
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

    <form method="post" id="place_trip_create" action="{{route('places.trips.store')}}">
        @csrf
        <input type="hidden" id="form_qty_captain" name="qty_captain" value="1">
        <input type="hidden" id="type" name="type" value="">
        <input type="hidden" id="come_at" name="come_at" value="">
    </form>

    <div class="modal" id="request_sahm_modal">
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
                            <label class="form-label fs-5 fw-bold ">عدد الكباتن</label>
                            <!--begin::Input-->
                            <input type="number" id="qty_captain" name="qty" style="text-align: right;"
                                   class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="عدد الكباتن"
                                   min="1"
                                   step="1"
                                   value="1"/>
                            <!--end::Input-->
                        </div>
                        <!--begin::Col-->
                    </div>
                    <!--begin::Separator-->
                    <div class="separator separator-dashed mt-6 mb-6"></div>
                    <div class="row">
                        <!--begin::Input group-->
                        <!--begin::Col-->
                        <div class="col-lg-6 mt-10">
                            <!--begin::Heading-->

                            <!--begin::Radio group-->
                            <div class="btn-group w-100 w-lg-50" data-kt-buttons="true"
                                 data-kt-buttons-target="[data-kt-button]">
                                <!--begin::Radio-->
                                <label
                                    class="btn btn-outline btn-color-muted btn-active-primary active"
                                    data-kt-button="true">
                                    <!--begin::Input-->
                                    <input class="btn-check" id="customer_radio_btn" checked="checked"  type="radio" name="type" value="immediately"/>فوري
                                    <!--end::Input-->
                                </label>
                                <!--end::Radio-->

                                <!--begin::Radio-->
                                <label
                                    class="btn btn-outline btn-color-muted btn-active-primary"
                                    data-kt-button="true">
                                    <!--begin::Input-->
                                    <input class="btn-check" type="radio" id="place_radio_btn"
                                           name="type"
                                           value="later"/>
                                    <!--end::Input-->
                                    آجل
                                </label>
                                <!--end::Radio-->


                            </div>
                            <!--end::Radio group-->

                        </div>
                        <!--begin::Col-->

                        <!--begin::Col-->
                        <div class="col-lg-4 mt-1" id="later">
                            <!--begin::Label-->
                            <label class="form-label fs-5 fw-bold ">المدة ( دقيقة ) </label>
                            <!--begin::Input-->
                            <input type="number" id="mints" name="come_at" style="text-align: right;"
                                   class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="المدة ( دقيقة )"
                                   min="1"
                                   step="1"
                                   value="5"/>
                            <!--end::Input-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="separator separator-dashed mt-6 mb-6"></div>

                </div>
                <div class="modal-footer" style="justify-content:center">
                    <button type="button" id="submit_request" class="btn btn-primary">اطلب</button>
                    <button type="button" id="cancel_request" class="btn btn-danger" >الغاء</button>
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
                    'lengthMenu': [[20, 30, 40, -1], [ 20, 30, 40, 'الكل']],
                    order: [3, 'desc'],
                    stateSave: false,
                    select: {
                        style: 'multi',
                        selector: 'td:first-child input[type="checkbox"]',
                        className: 'row-selected'
                    },
                    ajax: {
                        // url: "https://preview.keenthemes.com/api/datatables.php",
                        url: "{{route('places.trips.index')}}",
                    },
                    columns: [
                        {data: 'id'},
                        {data: 'owner_name'},
                        {data: 'captain_name'},
                        {data: 'created_at'},
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
                            targets: -1,
                            orderable: false,
                            className: 'text-end',
                        },
                    ],
                    rowCallback: function (row, data) {
                        if (data.is_success_row) {
                            $(row).addClass('success_row');
                        } else if (data.is_primary_row ) {
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
                        searchParams[column] = $(this).val().toLowerCase();
                        dt.search(JSON.stringify(searchParams)).draw();
                    });
                }

                // const filterSearch = document.querySelector('#search');
                // filterSearch.addEventListener('keyup', function (e) {
                //     dt.search(e.target.value,'search').draw();
                // });

                addSearchParam('#date', 'date');
            }

            // Init toggle toolbar
            var initToggleToolbar = function () {
                // Toggle selected action toolbar
                // Select all checkboxes
                const container = document.querySelector('#datatable');
                const checkboxes = container.querySelectorAll('[type="checkbox"]');
                // Select elements
                const deleteSelected = document.querySelector('#delete_selected');

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
                                    axios.post('{{route('places.trips.cancel_selected')}}',{'ids':ids}).then(function (response) {
                                        dt.draw();
                                    }).catch(function (error) {
                                        if (error.response && error.response.status === 401 && error.response.data.message === 'Unauthenticated.') {
                                            window.location.reload();
                                        }else if(error.response && error.response.status === 419){
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
                                            }else if(error.response && error.response.status === 419){
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
                } else {
                    toolbarBase.classList.remove('d-none');
                    toolbarSelected.classList.add('d-none');
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


            $('#request_sahm').click(function (){
                $('#request_sahm_modal').modal('show')
            })
            $('#submit_request').click(function (){
                disableButton('submit_request')
               var qty_captain =  $('#qty_captain').val()
               var mints =  $('#mints').val()
                var selectedValue = $('input[name="type"]:checked').val();

                if(qty_captain && selectedValue && mints){
                    $('#form_qty_captain').val(qty_captain)
                    $('#type').val(selectedValue)
                    $('#come_at').val(mints)
                    $('#place_trip_create').submit()
                    enableButton('submit_request')
                }else{
                    alert("تأكد من تعبئة الحقول  ")
                    enableButton('submit_request')
                }

            })
            $('#cancel_request').click(function (){
                $('#request_sahm_modal').modal('hide')
            })

        });

        // Class definition

    </script>
    <script>
        $(document).ready(function(){
            $('#later').hide();
            $("#date").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1901,
                maxYear: parseInt(moment().format("YYYY"),12)
            });

            $('input[name="type"]').on('change', function () {
                var selectedValue = $(this).val();
                if (selectedValue === 'immediately') {
                    $('#later').hide();
                } else if (selectedValue === 'later') {
                    $('#later').show();
                }
            });

        });
    </script>



@endsection
