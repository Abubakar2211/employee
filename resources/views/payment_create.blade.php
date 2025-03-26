@extends('components.main')
@section('main-section')
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">

                <!-- Default Basic Forms Start -->
                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">New Employee Created Form</h4>
                            <p class="mb-30">Insert the employee information</p>
                        </div>
                    </div>
                    <form action="{{ route('payment.store') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Employee:</label>
                            <div class="col-sm-12 col-md-10">
                                <select class="form-control mb-3" name="employee_id" id="employee_id">
                                    <option value="">Select The Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->employee_id }}">{{ $employee->employee_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Payment:</label>
                            <div class="col-sm-12 col-md-10">
                                <input class="form-control" name="payment" placeholder="Select Payment"
                                    type="number">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Payment Date:</label>
                            <div class="col-sm-12 col-md-10">
                                <input class="form-control date-picker" name="date_time" placeholder="Select Date"
                                    type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Status:</label>
                            <div class="col-sm-12 col-md-10">
                                <input type="hidden" name="employee_status" value="0">
                                <input type="checkbox" class="switch-btn" name="employee_status" value="1"
                                    data-color="#0099ff" checked>
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
