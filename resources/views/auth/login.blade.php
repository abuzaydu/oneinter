@extends('main.app')
@section('fill')
<body class="auth-prod-slider">
	<div class="blur-bg-images"></div>
	<div class="auth-wrapper">
		<div class="auth-content container">
			<div class="card">
				<div class="align-items-center" style="display: flex; justify-content: center; align-items: center;">
					<div class="col-md-6">
                    <div class="card-body">
                        <h4 class="mb-3 f-w-400">Login into your account</h4>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email -->
                            <div class="form-group mb-2">
                                <label class="form-label" for="email">Enter Email</label>
                                <input type="email" 
                                    id="email" 
                                    name="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    placeholder="name@sitename.com" 
                                    value="{{ old('email') }}" 
                                    required 
                                    autofocus 
                                    autocomplete="username">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="password">Enter Password</label>
                                <input type="password" 
                                    id="password" 
                                    name="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    placeholder="Allow only max 14 characters" 
                                    required 
                                    autocomplete="current-password">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="form-group text-start mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Save credentials
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button class="btn btn-primary mb-4" type="submit">Login</button>
                        </form>

                        <!-- Password Reset and Register Links -->
                        <p class="mb-2 text-muted">
                            Forgot password? 
                            <a href="{{ route('password.request') }}" class="f-w-400">Reset</a>
                        </p>
                        
                    </div>

					</div>
					
				</div>
			</div>
		</div>
	</div>
	<!-- [ signin-img-slider2 ] end -->

	<!-- Required Js -->
    <script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>



</body>
@endsection