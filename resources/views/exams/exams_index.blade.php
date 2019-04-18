@extends('layouts.main_layout')

@section('title', 'Home')

@section('content')
	
	<h4>Exams</h4>

	<hr>

	<div id="examsContainer">
		{{-- <ul id="exams"> --}}
		<div class="row">
			@foreach($exams as $index => $exam)
{{-- 				<li>
					{{$exam->exam_name}} || <a href="{{route('exams view exam', $exam->id)}}">Manage Exam</a> | 
					@if(!$exam->hasQuestions())
						<span style="color:red;"><i class="fas fa-exclamation-triangle"></i> This exam has no questions!</span>
					@elseif($exam->hasMissingCorrectAnswers())
						<span style="color:red;"><i class="fas fa-exclamation-triangle"></i> This exam has {{$exam->hasMissingCorrectAnswers()}} missing correct answers for questions.</span>
					@else
						<a href="{{route('exams take exam', $exam->id)}}">Take Exam</a>
					@endif
					| <button class="no-border deleteExamBtn" style="padding:0;color:#4582EC;" data-exam-id="{{$exam->id}}" data-exam-title="{{$exam->exam_name}}">Delete Exam</button>
				</li> --}}
				<div class="col-md-4">
					<div class="card {{!$exam->hasQuestions() || $exam->hasMissingCorrectAnswers() ? 'border-danger' : ''}} mb-3" style="max-width: 20rem;">
						<div class="card-header">{{$exam->exam_name}}</div>
						<div class="card-body">
							<p class="card-text">{{$exam->exam_description}}</p>

							<hr>
							
							@if(!$exam->hasQuestions())
								<span style="color:red;"><i class="fas fa-exclamation-triangle"></i> This exam has no questions!</span>
							@elseif($exam->hasMissingCorrectAnswers())
								<span style="color:red;"><i class="fas fa-exclamation-triangle"></i> This exam has {{$exam->hasMissingCorrectAnswers()}} missing correct answers for questions.</span>
							@else
								<a href="{{route('exams take exam', $exam->id)}}">Take Exam <i class="fas fa-tasks"></i></a>
							@endif
								|
								<a href="{{route('exams view exam', $exam->id)}}">Manage Exam <i class="fas fa-tools"></i></a>
								|
								<button class="no-border deleteExamBtn" style="padding:0;color:#4582EC;" data-exam-id="{{$exam->id}}" data-exam-title="{{$exam->exam_name}}"><i class="fas fa-trash"></i> Delete Exam</button>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>

	<hr>

	{{-- <a href="{{route('exams add exam')}}">Create new exam</a> --}}
	<div id="inputs">
		<a href="#" id="createNewExamBtn">Create new exam</a>
	</div>

@endsection

@section('scripts')

<script>
	function removeExam(examId) {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			url: "{{route('exam remove exam')}}",
			method: 'post',
			data: {
				exam_id: examId
			},
			success: function () {
				window.location.href = "/";
			}
		});
	}

	$(document).ready(function () {

		$(document).on('click', '.deleteExamBtn', function () {
			showConfirmationModal('Delete Exam', '\
				You are about to delete the exam titled '+$(this).data('exam-title')+'.<br /><br />Are you sure this is what you want to do?\
				', 'removeExam('+$(this).data('exam-id')+')');
		});

		$(document).on('click', '#createNewExamBtn', function () {
			$(this).hide();
			$('#inputs').append('\
				<input class="form-control" type="text" id="name" placeholder="Exam Name" /> \
				<textarea class="form-control" id="description" placeholder="Exam Description"></textarea>\
				<select class="form-control" id="examTime"><option value="0">No Limit</option>\
				<option value="10">10 minutes</option>\
				<option value="15">15 minutes</option>\
				<option value="30">30 minutes</option>\
				<option value="45">45 minutes</option>\
				<option value="60">60 minutes</option>\
				</select>\
				<button class="btn btn-primary" id="createExamBtn">Create Exam</button>\
				<button class="btn btn-outline-info" id="cancelCreateExamBtn">Cancel</button>\
				');
		});

		$(document).on('click', '#cancelCreateExamBtn', function () {
			$(this).remove();
			$('#inputs').load(window.location.href + ' #inputs');
		});

		$(document).on('click', '#createExamBtn', function () {
			$(this).attr('disabled', true);
			$(this).html('Please Wait..');

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: "{{route('exams add exam')}}",
				method: 'post',
				data: {
					exam_name: $('#name').val(),
					exam_description: $('#description').val(),
					exam_timelimit: $('#examTime').val(),
				},
				success: function() {
					$(this).remove();
					$('#inputs').load(window.location.href + ' #inputs');
					$('#examsContainer').load(window.location.href + ' #exams');
				}
			});
		});

	});
</script>

@endsection