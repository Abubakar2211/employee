@extends('components.main')
@section('main-section')
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <!-- Default Basic Forms Start -->
                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Payment Data Updated.</h4>
                            <p class="mb-30">Update the payment data.</p>
                        </div>
                    </div>
                    <form action="{{ route('payment.update', $payment->payment_id) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Employee Name:</label>
                            <div class="col-sm-12 col-md-10">
                                <label for="employee_name">{{ $payment->employee->employee_name }}</label>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Payment:</label>
                            <div class="col-sm-12 col-md-10">
                                <input class="form-control" name="payment" value="{{ $payment->payment }}"
                                    placeholder="Enter Payment" type="number">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Payment Date:</label>
                            <div class="col-sm-12 col-md-10">
                                <input class="form-control date-picker" name="date_time" value="{{ $payment->date_time }}"
                                    placeholder="Select Date" type="text">
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
