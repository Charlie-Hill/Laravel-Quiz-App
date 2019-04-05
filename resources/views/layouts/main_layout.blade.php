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
	@if(empty($hideNav))
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
		<a class="navbar-brand" href="#">Quiz</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarColor01">
			<div class="collapse navbar-collapse" id="navbarColor01">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="/exams">Exams <span class="sr-only">(current)</span></a>
					</li>
				</ul>
			<ul class="navbar-nav d-done d-lg-flex ml-2 order-3">
				<li class="nav-item divider"></li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="dropdown"><i class="fas fa-user"></i> {{Auth::user()->name}} <span class="caret"></span></a>

					<div class="dropdown-menu" aria-lablledby="dropdown">
						<a class="dropdown-item" href="#">Item</a>
						<a class="dropdown-item" href="#">Item</a>
						<a class="dropdown-item" href="#">Item</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a>
						<form id="logout-form" action="/logout" method="POST" style="display: none;">{{ csrf_field() }}</form>
					</div>
				</li>
			</ul>
			</div>			
		</div>
	</nav>
	@endif

	<div class="container mt-4">
		@yield('content')
	</div>

	<div id="modalsContainer">
		@yield('modals')
	</div>

	<script src="{{asset('assets/js/jquery-331.min.js')}}"></script>
	<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('assets/js/global.js')}}"></script>
	@yield('scripts')

</body>