@extends('components.main')
@section('main-section')
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
		<div class="xs-pd-20-10 pd-ltr-20">
			<div class="row clearfix progress-box">
				<div class="col-lg-3 col-md-6 col-sm-12 mb-30">
					<div class="card-box pd-30 height-100-p">
						<div class="progress-box text-center">
							<h5 class="text-blue padding-top-10 h5">My All Employees</h5>
							<span class="d-block">{{ $employee_total }}% Average <i class="fa fa-line-chart text-blue"></i></span>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-12 mb-30">
					<div class="card-box pd-30 height-100-p">
						<div class="progress-box text-center">
							<h5 class="text-light-green padding-top-10 h5">Employee Active</h5>
							<span class="d-block">{{ $employee_active }}% Average <i class="fa text-light-green fa-line-chart"></i></span>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-12 mb-30">
					<div class="card-box pd-30 height-100-p">
						<div class="progress-box text-center">
							<h5 class="text-light-orange padding-top-10 h5">Employee Deactive</h5>
							<span class="d-block">{{ $employee_deactive }}% Average <i class="fa text-light-orange fa-line-chart"></i></span>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-12 mb-30">
					<div class="card-box pd-30 height-100-p">
						<div class="progress-box text-center">
							<h5 class="text-light-purple padding-top-10 h5">Total Payment Active</h5>
							<span class="d-block">{{ $total_payments }}% Average <i class="fa text-light-purple fa-line-chart"></i></span>
						</div>
					</div>
				</div>
			</div>


@endsection
