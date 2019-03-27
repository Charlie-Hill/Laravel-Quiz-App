<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Quiz - @yield('title')</title>

	<link rel="stylesheet" href="{{asset('assets/css/custom_strap.min.css')}}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<style>
		.no-border {
			border: none;
			background-color: transparent;
			cursor: pointer;
		}
	</style>
</head>
<body>

	<div class="container">
		@yield('content')
	</div>

	<script src="{{asset('assets/js/jquery-331.min.js')}}"></script>
	<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
	@yield('scripts')

</body>