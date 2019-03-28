@extends('layouts.main_layout')

@section('title', 'Home')

@section('content')
	
	<h4>Exams</h4>

	<ul>
		@foreach($exams as $exam)
			<li>
				<a href="{{route('exams view exam', $exam->id)}}">{{$exam->exam_name}} | <a href="{{route('exams take exam', $exam->id)}}">Take Exam</a></a>
			</li>
		@endforeach
	</ul>

	<hr>

	<a href="{{route('exams add exam')}}">Create new exam</a>

@endsection