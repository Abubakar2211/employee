@extends('components.main')
@section('main-section')
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="title">
                        <h4>Form</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('employee.index') }}">Employee</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Employee</li>
                        </ol>
                    </nav>
                </div>
                <!-- Default Basic Forms Start -->
                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Employee Data Updated.</h4>
                            <p class="mb-30">Update the employee data.</p>
                        </div>
                    </div>
                    <form action="{{ route('employee.update',$employee->employee_id) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Employee Code:</label>
                            <div class="col-sm-12 col-md-10">
                                <input class="form-control" type="text" name="employee_code" value="{{$employee->employee_code}}"
                                    placeholder="Enter Employee Code">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Name:</label>
                            <div class="col-sm-12 col-md-10">
                                <input class="form-control" type="text" name="employee_name" value="{{$employee->employee_name}}"
                                    placeholder="Enter Employee Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Email:</label>
                            <div class="col-sm-12 col-md-10">
                                <input class="form-control" type="email" name="employee_email" value="{{$employee->employee_email}}"
                                    placeholder="Enter Employee Email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Password:</label>
                            <div class="col-sm-12 col-md-10">
                                <input class="form-control" type="password" name="employee_password" value="{{$employee->employee_password}}"
                                    placeholder="Enter Employee Password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Number:</label>
                            <div class="col-sm-12 col-md-10">
                                <input class="form-control" type="text" name="employee_number" value="{{$employee->employee_number}}"
                                    placeholder="Enter Employee Number">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">CNIC:</label>
                            <div class="col-sm-12 col-md-10">
                                <input class="form-control" type="text" name="employee_CNIC" value="{{$employee->employee_CNIC}}"
                                    placeholder="Enter Employee CNIC">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Date Of Birth:</label>
                            <div class="col-sm-12 col-md-10">
                                <input class="form-control date-picker" name="employee_d_o_b" value="{{$employee->employee_d_o_b}}" placeholder="Select Date" type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Date Of Join:</label>
                            <div class="col-sm-12 col-md-10">
                                <input class="form-control date-picker" name="employee_d_o_j" value="{{$employee->employee_d_o_j}}"  placeholder="Select Date" type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Status:</label>
                            <div class="col-sm-12 col-md-10">
                                <input type="hidden" name="employee_status" value="0" >
                                <input type="checkbox" class="switch-btn" name="employee_status" value="1" {{ $employee->employee_status ? 'checked' : '' }} data-color="#0099ff">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div>
                <!-- Default Basic Forms End -->

            </div>
        @endsection
