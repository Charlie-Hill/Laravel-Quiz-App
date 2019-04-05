@extends('layouts.main_layout')

@section('title', 'Login')

@section('content')

	<form method="post" action="{{ route('login') }}">
		<fieldset>
			@csrf
			<legend>Login to your account</legend>
			<hr>
			@if(isset($errors))
				@foreach($errors->all() as $error)
				<div class="alert alert-danger">
					<i class="fas fa-exclamation-triangle"></i> {{$error}}
				</div>
				@endforeach
			@endif
			<div class="form-group">
				<label for="name">Username</label>
				<input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" placeholder="Username">
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" placeholder="Password">
			</div>
			<div class="form-group">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="rememberMe">
					<label class="custom-control-label" for="rememberMe">Remember Me</label>
				</div>
			</div>
			<button type="button" id="loginBtn" class="btn btn-primary">Login <i class="fas fa-sign-in-alt"></i></button>
			<a href="{{route('register')}}"><small>Need an account?</small></a>
		</fieldset>
	</form>

@endsection

@section('scripts')
	<script>
		$(document).ready(function() {

			$('#loginBtn').on('click', function () {
				$(this).attr('disabled', true);
				$(this).html('Please wait.. <i class="fa fa-spinner fa-spin fa-fw"></i>');
				$(this).closest('form').submit();
			});

		});
	</script>
@endsection