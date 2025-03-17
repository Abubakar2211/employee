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
                                <p>{{$employee->employee_code}}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Name:</label>
                            <div class="col-sm-12 col-md-10">
                                <p>{{$employee->employee_name}}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Email:</label>
                            <div class="col-sm-12 col-md-10">
                                <p>{{$employee->employee_email}}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Number:</label>
                            <div class="col-sm-12 col-md-10">
                                <p>{{$employee->employee_number}}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">CNIC:</label>
                            <div class="col-sm-12 col-md-10">
                                <p>{{$employee->employee_CNIC}}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Date Of Birth:</label>
                            <div class="col-sm-12 col-md-10">
                                <p>{{$employee->employee_d_o_b}}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Date Of Join:</label>
                            <div class="col-sm-12 col-md-10">
                                <p>{{$employee->employee_d_o_j}}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Status:</label>
                            <div class="col-sm-12 col-md-10">
                                <span class="badge {{ $employee->employee_status ? 'badge-success' : 'badge-danger' }}">
                                    {{ $employee->employee_status ? 'Active' : 'Deactive' }}
                                </span>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex justify-content-end">
                        <a href="{{route('employee.index')}}" class="btn btn-primary">Back</a>
                    </div>
                </div>
                <!-- Default Basic Forms End -->

            </div>
        @endsection
