@extends('layouts.main_layout')

@section('title', 'Home')

@section('content')
	
	<h4>Exams</h4>

	<ul>
		@foreach($exams as $exam)
			<li>
				{{$exam->exam_name}} || <a href="{{route('exams view exam', $exam->id)}}">Manage Exam</a> | 
				@if(!$exam->hasQuestions())
					<span style="color:red;"><i class="fas fa-exclamation-triangle"></i> This exam has no questions!</span>
				@elseif($exam->hasMissingCorrectAnswers())
					<span style="color:red;"><i class="fas fa-exclamation-triangle"></i> This exam has {{$exam->hasMissingCorrectAnswers()}} missing correct answers for questions.</span>
				@else
					<a href="{{route('exams take exam', $exam->id)}}">Take Exam</a>
				@endif
				| <button class="no-border deleteExamBtn" data-exam-title="{{$exam->exam_name}}">Delete Exam</button>
			</li>
		@endforeach
	</ul>

	<hr>

	<a href="{{route('exams add exam')}}">Create new exam</a>

@endsection

@section('scripts')

<script>
	$(document).ready(function () {

		$(document).on('click', '.deleteExamBtn', function () {
			showConfirmationModal('Delete Exam', '\
				You are about to delete the exam titled '+$(this).data('exam-title')+'.<br /><br />Are you sure this is what you want to do?\
				', 'test');
		});

	});
</script>

@endsection