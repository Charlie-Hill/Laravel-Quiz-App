@extends('layouts.main_layout')

@section('title', 'Register')

@section('content')

	<form method="post" action="{{ route('register') }}">
		<fieldset>
			@csrf
			<legend>Register an account</legend>
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
				<label for="email">Email</label>
				<input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" placeholder="Email">
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" placeholder="Password">
			</div>
			<div class="form-group">
				<label for="password_confirmation">Confirm Password</label>
				<input type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
			</div>
			<button type="button" class="btn btn-primary" id="registerBtn">Register</button>
			<a href="{{route('login')}}"><small>Already have an account. Login here</small></a>
		</fieldset>
	</form>

@endsection

@section('scripts')
	<script>
		$(document).ready(function () {
			$('#registerBtn').on('click', function () {
				$(this).attr('disabled', true);
				$(this).html('Please wait.. <i class="fa fa-spinner fa-spin fa-fw"></i>');
				$(this).closest('form').submit();
			});
		});
	</script>
@endsection