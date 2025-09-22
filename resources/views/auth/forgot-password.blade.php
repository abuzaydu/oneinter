@extends('main.app')
@section('fill')
<body>
<div class="auth-wrapper">
	<!-- [ reset-password ] start -->
	<div class="auth-content container">
		<div class="card">
			<div class="row align-items-center">
				<div class="col-md-6">
					<div class="card-body">
						<img src="{{ asset('assets/images/logo-dark.svg') }}" alt="" class="img-fluid mb-4">
						<h4 class="mb-3 f-w-400">Reset your password</h4>

						<!-- Session Status -->
						@if (session('status'))
							<div class="alert alert-success mb-3">
								{{ session('status') }}
							</div>
						@endif

						<!-- Validation Errors -->
						@if ($errors->any())
							<div class="alert alert-danger mb-3">
								<ul class="mb-0">
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif

						<form method="POST" action="{{ route('password.email') }}">
							@csrf
							<div class="form-group mb-4">
								<label class="form-label" for="email">Enter Email</label>
								<input type="email"
								       name="email"
								       id="email"
								       class="form-control @error('email') is-invalid @enderror"
								       placeholder="name@sitename.com"
								       value="{{ old('email') }}"
								       required
								       autofocus>
								@error('email')
									<div class="invalid-feedback">
										{{ $message }}
									</div>
								@enderror
							</div>

							<button type="submit" class="btn btn-primary mb-4 btf">Reset password</button>
						</form>
					</div>
				</div>
				<div class="col-md-6 d-none d-md-block">
					<img src="{{ asset('assets/images/auth-bg.jpg') }}" alt="" class="img-fluid">
				</div>
			</div>
		</div>
	</div>
	<!-- [ reset-password ] end -->
</div>
<!-- Required Js -->
<script src="assets/js/vendor-all.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
</body>
@endsection