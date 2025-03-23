@extends('components.main')
@section('main-section')
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <!-- Default Basic Forms Start -->
                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Employee Data Updated.</h4>
                            <p class="mb-30">Update the employee data.</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Employee Name:</label>
                        <div class="col-sm-12 col-md-10">
                            <p>{{ $payment->employee->employee_name }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Payment:</label>
                        <div class="col-sm-12 col-md-10">
                            <p>Rs:{{ $payment->payment }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Payment Date:</label>
                        <div class="col-sm-12 col-md-10">
                            <p>{{ $payment->date_time }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Status:</label>
                        <div class="col-sm-12 col-md-10">
                            <span class="badge {{ $payment->employee_status ? 'badge-success' : 'badge-danger' }}">
                                {{ $payment->employee_status ? 'Active' : 'Deactive' }}
                            </span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('payment.index') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
                <!-- Default Basic Forms End -->

            </div>
        @endsection
