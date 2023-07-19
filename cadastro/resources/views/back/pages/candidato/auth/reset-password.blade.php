@extends('back.layout.auth-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Reset password')
@section('content')
<div class="col-md-12" class="center">
	<img src="/back/vendors/images/forgot-password.png" class="rounded mx-auto d-block" width="200px" alt="">
</div>
<div class="login-box bg-white box-shadow border-radius-10">
	<div class="login-title">
		<h2 class="text-center text-primary">Reset Password</h2>
	</div>
	<h6 class="mb-20">Enter your new password, confirm and submit</h6>
	<form action="{{ route('candidato.reset-password-handler', ['token'=>request()->token]) }}" method="POST">
		@csrf
		@if ( Session::get('fail'))
			<div class="alert alert-danger">
				{{ Session::get('fail') }}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		@endif
		@if ( Session::get('success'))
			<div class="alert alert-success">
				{{ Session::get('success') }}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		@endif
		<div class="input-group custom">
			<input type="password" class="form-control form-control-lg" placeholder="New Password"
			name="new_password" value="{{ old('new_password') }}">
			<div class="input-group-append custom">
				<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
			</div>
		</div>
		@error('new_password')
			<div class="d-block text-danger" style="margin-top: -25px;">{{ $message }}</div>
		@enderror
		<div class="input-group custom">
			<input type="password" class="form-control form-control-lg" placeholder="Confirm New Password"
			name="new_password_confirmation" value="{{ old('new_password_confirmation') }}">
			<div class="input-group-append custom">
				<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
			</div>
		</div>
		@error('new_password_confirmation')
			<div class="d-block text-danger" style="margin-top: -25px;">{{ $message }}</div>
		@enderror
		<div class="row align-items-center">
			<div class="col-5">
				<div class="input-group mb-0">

					<input class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">


				</div>
			</div>
		</div>
	</form>
</div>
@endsection
