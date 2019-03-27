@extends('layouts.main_layout')

@section('title', 'Viewing Exam')

@section('content')
	
	<div class="row">
		<div class="col-lg-12">
		<h2>Exam: {{$exam->exam_name}}</h2>
		<h4>{{$exam->exam_description}}</h4>
		<a href="{{route('exams index')}}"><span class="fas fa-arrow-left"></span> Back</a>
		</div>
	</div>

	<hr>

	<div class="row">
		<div id="questions">
			@if(count($exam->questions))
			<h6>Questions:</h6>
				<ul>
					@foreach($exam->questions as $question)
						<li>
							<a href="{{route('quiz view question', $question->id)}}">{{$question->quiz_question}}</a>
						</li>
					@endforeach
				</ul>
			@endif
		</div>
	</div>

	<button type="button" class="btn btn-primary" id="addQuestionBtn">Add Question <i class="fas fa-plus"></i></button>

@endsection

@section('scripts')

	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script>
		$(document).ready(function () {

			$(document).on('click', '#addQuestionBtn', function () {
				$(this).hide();
				$('#questions').append('\
					<input type="text" class="form-control" name="quiz_question" id="quizQuestion" placeholder="Enter Question.." autocomplete="off" />\
					<button type="button" class="btn btn-success" id="submitAddQuestionBtn">Submit</button>\
					');
			});

			$(document).on('click', '#submitAddQuestionBtn', function () {
				$(this).attr('disabled', true);
				$(this).html('Please Wait..');

				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				$.ajax({
					url: "{{route('quiz exam add question')}}",
					method: 'post',
					data: {
						exam_id: {{$exam->id}},
						quiz_question: $('#quizQuestion').val()
					},
					success: function () {
						$('#submitAddQuestionBtn').hide();
						$('#questions').load(location.href + ' #questions');
						$('#addQuestionBtn').show();
					}
				});
			});

		});
	</script>

@endsection