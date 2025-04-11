<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>DeskApp - Bootstrap Admin Dashboard HTML Template</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('vendors/images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('vendors/images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('vendors/images/favicon-16x16.png') }}">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/core.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/icon-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/jvectormap/jquery-jvectormap-2.0.3.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/style.css') }}">
    <!-- bootstrap-tagsinput css -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
    <!-- bootstrap-touchspin css -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('src/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.css') }}">
    <!-- switchery css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/switchery/switchery.min.css') }}">
    <!-- Datatable -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('src/plugins/datatables/css/responsive.bootstrap4.min.css') }}">



    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/style.css') }}">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-119386393-1');
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>

<body>
    {{-- <div class="pre-loader">
        <div class="pre-loader-box">
            <div class="loader-logo"><img src="{{ asset('vendors/images/deskapp-logo.svg') }}" alt=""></div>
            <div class='loader-progress' id="progress_div">
                <div class='bar' id='bar1'></div>
            </div>
            <div class='percent' id='percent1'>0%</div>
            <div class="loading-text">
                Loading...
            </div>
        </div>
    </div> --}}

    <div class="header">
        <div class="header-left">
            <div class="menu-icon dw dw-menu"></div>
            <div class="search-toggle-icon dw dw-search2" data-toggle="header_search"></div>
        </div>
        <div class="header-right">
            <div class="user-info-dropdown">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        <span class="user-icon">
                            <img src="{{ asset('vendors/images/photo1.jpg') }}" alt="">
                        </span>
                        @if (session()->has('employee_name'))
                            <span class="user-name">{{ session('employee_name') }}</span>
                        @else
                            <span class="user-name">Guest</span>
                        @endif

                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item">
                                <i class="dw dw-logout"></i> Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            {{-- <div class="github-link">
                <a href="https://github.com/dropways/deskapp" target="_blank"><img src="{{asset('vendors/images/github.svg')}}"
                        alt=""></a>
            </div> --}}
        </div>
    </div>

    <div class="left-side-bar">
        <div class="brand-logo">
            <a href="/dashboard">
                <img src="{{ asset('vendors/images/deskapp-logo.svg') }}" alt="" class="dark-logo">
                <img src="{{ asset('vendors/images/deskapp-logo-white.svg') }}" alt="" class="light-logo">
            </a>
            <div class="close-sidebar" data-toggle="left-sidebar-close">
                <i class="ion-close-round"></i>
            </div>
        </div>
        <div class="menu-block customscroll">
            <div class="sidebar-menu">
                <ul id="accordion-menu">
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon dw dw-house-1"></span><span class="mtext">Home</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon dw dw-user"></span><span class="mtext">Employee</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="{{ route('employee.index') }}">All Employee</a></li>
                            <li><a href="{{ route('payment.index') }}">Employee payment</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="mobile-menu-overlay"></div>

    @yield('main-section')

    </div>
    <!-- js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Fix: Prevent Dropdown from Closing on Click -->
    <script>
        $(document).ready(function() {
            // Update employee dropdown based on status selection
            $('#statusFilter').change(function() {
                var status = $(this).val();

                $.ajax({
                    url: '/get-employees-by-status',
                    type: 'GET',
                    data: {
                        status: status
                    },
                    success: function(response) {
    $('#employeeFilter').empty().append('<option value="">All Employees</option>');
    $.each(response, function(id, displayText) {
        $('#employeeFilter').append('<option value="' + id + '">' + displayText + '</option>');
    });
},

                    error: function(xhr) {
                        console.log('Error:', xhr.responseText);
                    }
                });
            });

            // Form submission handler
            $('#filterForm').submit(function(e) {
                e.preventDefault();

                var status = $('#statusFilter').val();
                var employeeId = $('#employeeFilter').val();

                $.ajax({
                    url: '/filter-employees',
                    type: 'GET',
                    data: {
                        status: status,
                        employee_id: employeeId
                    },
                    success: function(response) {
                        updateTable(response);
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr.responseText);
                    }
                });
            });


            function updateTable(employees) {
                var tbody = $('tbody');
                tbody.empty();

                $.each(employees, function(i, employee) {
                    var statusBadge = employee.employee_status ?
                        '<span class="badge badge-success">Active</span>' :
                        '<span class="badge badge-danger">Deactive</span>';

                    var row = '<tr>' +
                        '<td class="table-plus">' + (i + 1) + '</td>' +
                        '<td>' + (employee.employee_code || '') + '</td>' +
                        '<td>' + (employee.employee_name || '') + '</td>' +
                        '<td>' + (employee.employee_email || '') + '</td>' +
                        '<td>' + (employee.employee_number || '') + '</td>' +
                        '<td>' + (employee.employee_CNIC || '') + '</td>' +
                        '<td>' + (employee.employee_d_o_b || '') + '</td>' +
                        '<td>' + (employee.employee_d_o_j || '') + '</td>' +
                        '<td>' + statusBadge + '</td>' +
                        '<td><div class="dropdown">' +
                        '<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">' +
                        '<i class="dw dw-more"></i>' +
                        '</a>' +
                        '<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">' +
                        '<a class="dropdown-item" href="/employee/' + employee.employee_id + '/edit">' +
                        '<i class="dw dw-edit2"></i> Edit' +
                        '</a>' +
                        '</div>' +
                        '</div></td>' +
                        '</tr>';

                    tbody.append(row);
                });
            }
        });
    </script>


    <script>
        $(document).ready(function() {
            // Load active employees by default
            loadEmployees(1);
            $('.month-picker').attr('type', 'month');

            $('.month-picker').datepicker({
                format: "yyyy-mm",
                viewMode: "months",
                minViewMode: "months"
            });
            // When status changes - update employee dropdown
            $('#paymentStatusFilter').change(function() {
                var statusValue = $(this).val();
                loadEmployees(statusValue);
            });

            // Form submission handler - update table
            $('#paymentFilterForm').submit(function(e) {
                e.preventDefault();
                applyFilters();
            });

            // Function to load employees
            function loadEmployees(statusValue) {
                $.ajax({
                    url: '/filter-payments',
                    type: 'GET',
                    data: {
                        status: statusValue,
                        employees_only: true
                    },
                    success: function(response) {
                        updateEmployeeFilter(response.employees);
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr.responseText);
                    }
                });
            }

            // Function to apply filters and update table
            function applyFilters() {
                var statusValue = $('#paymentStatusFilter').val();
                var employeeId = $('#paymentEmployeeFilter').val();

                $.ajax({
                    url: '/filter-payments',
                    type: 'GET',
                    data: {
                        status: statusValue,
                        employee_id: employeeId
                    },
                    success: function(response) {
                        updatePaymentTable(response.payments);
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr.responseText);
                    }
                });
            }

            // Update employee filter dropdown
            function updateEmployeeFilter(employees) {
                var employeeFilter = $('#paymentEmployeeFilter');
                employeeFilter.empty().append('<option value="">All Employees</option>');

                $.each(employees, function(id, name_code) {
                    employeeFilter.append('<option value="' + id + '">' + name_code + '</option>');
                });
            }


            // Update payment table
            function updatePaymentTable(payments, total_payments) {
                var tableBody = $('#filter_payment_table tbody');
                tableBody.empty();

                if (payments.length === 0) {
                    tableBody.append('<tr><td colspan="7" class="text-center">No payments found</td></tr>');
                    return;
                }

                $.each(payments, function(index, payment) {
                    var currentMonth = $('#paymentEmployeeDate').val();
                    var row = '<tr>' +
                        '<td class="table-plus">' + (index + 1) + '</td>' +
                        '<td>' + payment.employee.employee_name + '</td>' +
                        '<td class="table-plus">Rs:' + payment.payment + '</td>' +
                        '<td>' + payment.date_time + '</td>' +
                        '<td>' + (payment.formatted_created_at || payment.created_at) + '</td>' +
                        '<td class="table-plus">Rs:' + (total_payments[payment.employee.employee_id] || 0) +
                        '</td>' +
                        '<td><span class="badge ' + (payment.employee.employee_status == 1 ?
                            'badge-success' : 'badge-danger') + '">' +
                        (payment.employee.employee_status == 1 ? 'Active' : 'Deactive') + '</span></td>' +
                        '<td>' +
                        '<div class="dropdown">' +
                        '<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">' +
                        '<i class="dw dw-more"></i></a>' +
                        '<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">' +
                        '<a class="dropdown-item" href="/payment/' + payment.payment_id +
                        '/edit"><i class="dw dw-edit2"></i> Edit</a>' +
                        '<a class="dropdown-item" href="/payments/' + payment.payment_id + '?month=' +
                        currentMonth + '"><i class="dw dw-money"></i> All Payment</a>' +
                        '</div></div></td></tr>';

                    tableBody.append(row);
                });
            }

            // Function to apply filters and update table
            function applyFilters() {
                var statusValue = $('#paymentStatusFilter').val();
                var employeeId = $('#paymentEmployeeFilter').val();
                var paymentDate = $('#paymentEmployeeDate').val(); // YYYY-MM format date

                $.ajax({
                    url: '/filter-payments',
                    type: 'GET',
                    data: {
                        status: statusValue,
                        employee_id: employeeId,
                        payment_date: paymentDate
                    },
                    success: function(response) {
                        updatePaymentTable(response.payments, response.total_payments);

                        // Simple month display update
                        if (response.payments.length > 0) {
                            var dateParts = response.payments[0].date_time.split('-');
                            $('#paymentMonthDisplay').text(
                                new Date(dateParts[0], dateParts[1] - 1).toLocaleString('default', {
                                    month: 'long'
                                }) +
                                ' ' + dateParts[0]
                            );
                        } else if (paymentDate) {
                            var dateParts = paymentDate.split('-');
                            $('#paymentMonthDisplay').text(
                                new Date(dateParts[0], dateParts[1] - 1).toLocaleString('default', {
                                    month: 'long'
                                }) +
                                ' ' + dateParts[0]
                            );
                        }
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr.responseText);
                    }
                });
            }
        });
    </script>

    <script src="{{ asset('vendors/scripts/core.js') }}"></script>
    <script src="{{ asset('vendors/scripts/script.min.js') }}"></script>
    <script src="{{ asset('vendors/scripts/process.js') }}"></script>
    <script src="{{ asset('vendors/scripts/layout-settings.js') }}"></script>
    <script src="{{ asset('src/plugins/jQuery-Knob-master/jquery.knob.min.js') }}"></script>
    <script src="{{ asset('src/plugins/highcharts-6.0.7/code/highcharts.js') }}"></script>
    <script src="{{ asset('src/plugins/highcharts-6.0.7/code/highcharts-more.js') }}"></script>
    <script src="{{ asset('src/plugins/jvectormap/jquery-jvectormap-2.0.3.css') }}"></script>
    <script src="{{ asset('src/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js') }}"></script>
    <script src="{{ asset('src/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('vendors/scripts/dashboard2.js') }}"></script>


    <!-- Datatable -->

    <script src="{{ asset('src/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/dataTables.responsive.min.js') }}""></script>
    <script src="{{ asset('src/plugins/datatables/js/responsive.bootstrap4.min.js') }}""></script>
    <!-- buttons for Export datatable -->
    <script src="{{ asset('src/plugins/datatables/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('src/plugins/datatables/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('src/plugins/switchery/switchery.min.js') }}"></script>

    <!-- bootstrap-tagsinput js -->
    <script src="{{ asset('src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}"></script>
    <script src="{{ asset('src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
    <!-- bootstrap-touchspin js -->
    <script src="{{ asset('src/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.css') }}"></script>
    <script src="{{ asset('src/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js') }}"></script>
    <script src="{{ asset('vendors/scripts/advanced-components.js') }}"></script>
    <!-- Datatable Setting js -->
    <script src="{{ asset('vendors/scripts/datatable-setting.js') }}"></script>
    <!-- add sweet alert js & css in footer -->
    <script src="{{ asset('src/plugins/sweetalert2/sweetalert2.all.js') }}"></script>
    <script src="{{ asset('src/plugins/sweetalert2/sweet-alert.init.js') }}"></script>


</body>

</html>
