@extends('components.main')
@section('main-section')
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">

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
                                        <!-- First Select Field -->
                                        <label for="filter1">Select the Employee Status:</label>
                                        <select class="form-control mb-2" id="filter1" name="filter1">
                                            @foreach ($allStatus as $status)
                                                <option value="{{ $status }}">{{ $status }}</option>
                                            @endforeach
                                        </select>

                                        <!-- Second Select Field -->
                                        <label for="filter2">Employees Status Names:</label>
                                        <select class="form-control mb-3" id="filter2" name="filter2">
                                        </select>
                                        <!-- Buttons -->
                                        <div class="d-flex justify-content-between">
                                            <button type="reset" id="resertFilter" class="btn btn-secondary">Reset
                                                Filter</button>
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
                                                            href="{{ route('employee.show', $employee->employee_id) }}"><i
                                                                class="dw dw-eye"></i> View</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('employee.edit', $employee->employee_id) }}">
                                                            <i class="dw dw-edit2"></i> Edit
                                                        </a>
                                                        <form
                                                            action="{{ route('employee.destroy', $employee->employee_id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="dropdown-item"><i class="dw dw-delete-3"></i>
                                                                Delete</button>
                                                        </form>
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
