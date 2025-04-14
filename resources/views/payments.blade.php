@extends('components.main')
@section('main-section')
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="main-container">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="autoCloseAlert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <script>
                            setTimeout(function() {
                                $('#autoCloseAlert').alert('close');
                            }, 3000);
                        </script>
                    @endif
                <!-- Simple Datatable start -->
                <div class="card-box mb-30">
                    <div class="d-flex justify-content-between align-items-center pd-20">
                        <div>
                            <h4 class="text-blue h4">Payments Tables</h4>
                            <p class="mb-0">This is payments records</p>
                        </div>
                        <div><h4 class="text-blue h4 check_month_payment" id="paymentMonthDisplay">
                            {{ \Carbon\Carbon::parse($current_month)->format('F Y') }}
                        </h4>
                        </div>
                        <div class="d-flex gap-2">
                            <!-- Add Employee Button -->
                            <!-- Dropdown Button -->
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="filterDropdown"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Filters
                                </button>
                                <form id="paymentFilterForm">
                                    <div class="dropdown-menu p-3" aria-labelledby="filterDropdown" style="width: 280px;">
                                        <label for="paymentStatusFilter">Select the Payment Status:</label>
                                        <select class="form-control mb-2" id="paymentStatusFilter" name="status">
                                            <option value="1">Active</option>
                                            <option value="0">Deactive</option>
                                            <option value="">All</option>
                                        </select>

                                        <label for="paymentEmployeeFilter">Employees Names:</label>
                                        <select class="form-control mb-3" id="paymentEmployeeFilter" name="employee_id">
                                            <option value="">All Employees</option>
                                        </select>
                                        <label for="payment_date">Payment Month:</label>
                                        <input class="form-control mb-3" id="paymentEmployeeDate" value="{{ $current_month }}" name="payment_date"
                                            placeholder="Select Month" type="month">
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('payment.index') }}" class="btn btn-secondary">Reset
                                                Filter</a>
                                            <button type="submit" class="btn btn-primary">Apply Filter</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <a href="{{ route('payment.create') }}" class="btn btn-primary mx-2">Add Payment </a>
                        </div>
                    </div>
                    <div class="pb-20">
                        <div class="table-responsive">
                            <table class="data-table table table-striped table-hover nowrap" id="filter_payment_table">
                                <thead>
                                    <tr>
                                        <th class="table-plus datatable-nosort">S.No</th>
                                        <th>Employee</th>
                                        <th>Employee Code</th>
                                        <th>Payment</th>
                                        <th>Date</th>
                                        <th>Payment Created</th>
                                        <th>Total Payment</th>
                                        <th>Status</th>
                                        <th class="datatable-nosort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($payments as $payment)
                                        <tr>
                                            <td class="table-plus">{{ $i++ }}</td>
                                            <td>{{ $payment->employee->employee_name }}</td>
                                            <td>{{ $payment->employee->employee_code }}</td>
                                            <td class="table-plus">Rs: {{ $payment->payment }}</td>
                                            <td>{{ $payment->date_time }}</td>
                                            <td>{{ $payment->created_at }}</td>
                                            <td class="table-plus">Rs: {{ $total_payments[$payment->employee_id] }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $payment->employee->employee_status == 1 ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $payment->employee->employee_status == 1 ? 'Active' : 'Deactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                        href="#" role="button" data-toggle="dropdown">
                                                        <i class="dw dw-more"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                        <a class="dropdown-item"
                                                            href="{{ route('payment.edit', $payment->payment_id) }}">
                                                            <i class="dw dw-edit2"></i> Edit
                                                        </a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('payments', $payment->payment_id) }}">
                                                            <i class="dw dw-money"></i> All Payment
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <!-- Simple Datatable end -->

            </div>
        @endsection
