@extends('components.main')
@section('main-section')
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <!-- Simple Datatable start -->
                <div class="card-box mb-30">
                    <div class="d-flex justify-content-between align-items-center pd-20">
                        <div>
                            <h4 class="text-blue h4">Payment Tables</h4>
                            <p class="mb-0">This is payments records</p>
                        </div>
                        <div class="d-flex gap-2">
                            <!-- Add Employee Button -->
                            <!-- Dropdown Button -->
                            <div class="dropdown">
                                <form id="employeeFilterForm">
                                    <div class="dropdown-menu p-3" aria-labelledby="filterDropdown" style="width: 280px;">
                                        <!-- Status Filter -->
                                        <label for="paymentStatusFilter">Select the Employee Status:</label>
                                        <select class="form-control mb-2" id="paymentStatusFilter"
                                            name="paymentStatusFilter">
                                            <option value="">Status</option>
                                            {{-- @foreach ($allStatus as $status)
                                                <option value="{{ $status }}">{{ $status }}</option>
                                            @endforeach --}}
                                        </select>

                                        <!-- Employee Name Filter -->
                                        <label for="paymentEmployeeFilter">Employees Names:</label>
                                        <select class="form-control mb-3" id="paymentEmployeeFilter"
                                            name="paymentEmployeeFilter">
                                            <option value="">Names</option>
                                        </select>

                                        <!-- Buttons -->
                                        <div class="d-flex justify-content-between">
                                            <button type="reset" id="resetPaymentFilter" class="btn btn-secondary">Reset
                                                Filter</button>
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
                            <table class="data-table table table-striped table-hover nowrap">
                                <thead>
                                    <tr>
                                        <th class="table-plus datatable-nosort">S.No</th>
                                        <th>Employee</th>
                                        <th>Payment</th>
                                        <th>Time</th>
                                        <th>Payment Status</th>
                                        <th class="datatable-nosort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($payments as $payment)
                                        <tr>
                                            <td class="table-plus">{{ $i++ }}</td>
                                            <td>{{ $payment->employee->employee_name }}</td>
                                            <td class="table-plus">Rs:{{ $payment->payment }}</td>
                                            <td>{{ $payment->date_time }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $payment->payment_status == 1 ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $payment->payment_status == 1 ? 'Active' : 'Deactive' }}
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
                                                            href="{{ route('payment.show', $payment->payment_id) }}"><i
                                                                class="dw dw-eye"></i> View</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('payment.edit', $payment->payment_id) }}">
                                                            <i class="dw dw-edit2"></i> Edit
                                                        </a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('payments', $payment->payment_id) }}">
                                                            <i class="dw dw-money"></i> All Payment
                                                        </a>
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
