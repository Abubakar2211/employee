@extends('components.main')
@section('main-section')
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
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
                            <h4 class="text-blue h4">Employees Tables</h4>
                            <p class="mb-0">This is employees records</p>
                        </div>
                        <div class="d-flex gap-2">
                            <!-- Add Employee Button -->
                            <!-- Dropdown Button -->
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="filterDropdown"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Filters
                                </button>
                                <form id="filterForm">
                                    <div class="dropdown-menu p-3" aria-labelledby="filterDropdown" style="width: 280px;">
                                        <!-- Status Filter -->
                                        <label for="statusFilter">Select the Employee Status:</label>
                                        <select class="form-control mb-2" id="statusFilter" name="status">
                                            <option value="Active">Active</option>
                                            <option value="Deactive">Deactive</option>
                                            <option value="all">All</option>
                                        </select>

                                        <!-- Employee Filter -->
                                        <label for="employeeFilter">Employees Names:</label>
                                        <select class="form-control mb-3" id="employeeFilter" name="employee_id">
                                            <option value="">All Employees</option>
                                            @foreach ($allEmployees as $id => $name)
                                                <option value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </select>

                                        <!-- Buttons -->
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('employee.index') }}" class="btn btn-secondary">Reset
                                                Filter</a>
                                            <button type="submit" class="btn btn-primary">Apply Filter</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <a href="{{ route('employee.create') }}" class="btn btn-primary mx-2">Add Employee</a>
                        </div>
                    </div>
                    <div class="pb-20">
                        <div class="table-responsive">
                            <table class="data-table table table-striped table-hover nowrap">
                                <thead>
                                    <tr>
                                        <th class="table-plus datatable-nosort">S.No</th>
                                        <th>Employee Code</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Number</th>
                                        <th>CNIC</th>
                                        <th>Date Of Birth</th>
                                        <th>Date Of Join</th>
                                        <th>Status</th>
                                        <th class="datatable-nosort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($employees as $employee)
                                        <tr>
                                            <td class="table-plus">{{ $i++ }}</td>
                                            <td>{{ $employee->employee_code }}</td>
                                            <td>{{ $employee->employee_name }}</td>
                                            <td>{{ $employee->employee_email }}</td>
                                            <td>{{ $employee->employee_number }}</td>
                                            <td>{{ $employee->employee_CNIC }}</td>
                                            <td>{{ $employee->employee_d_o_b }}</td>
                                            <td>{{ $employee->employee_d_o_j }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $employee->employee_status ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $employee->employee_status ? 'Active' : 'Deactive' }}
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
                                                            href="{{ route('employee.edit', $employee->employee_id) }}">
                                                            <i class="dw dw-edit2"></i> Edit
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
