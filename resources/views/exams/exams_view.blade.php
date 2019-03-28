@extends('layouts.main_layout')

@section('title', 'Viewing Exam')

@section('content')
	
	<div class="row">
		<div class="col-lg-12">
			<div id="title">
				<h2>Exam: {{$exam->exam_name}}</h2>
				<h5>{{$exam->exam_description}}</h5>
				<input type="hidden" id="examNameVal" value="{{$exam->exam_name}}">
				<input type="hidden" id="examDescriptionVal" value="{{$exam->exam_description}}">
			</div>

			<div class="row">
				<div class="col-md-6">
					<a href="{{route('exams index')}}"><i class="fas fa-arrow-left"></i> Back</a>
				</div>
				<div class="col-md-6" style="display:flex;flex-direction:column;align-items:flex-end;">
					<a href="#" class="no-border" id="editExamBtn"><i class="fas fa-edit"></i> Edit</a>
				</div>
			</div>
		</div>
	</div>

	<hr>

	<div class="row">
		<div id="questions" class="col-md-12">
			@if(count($exam->questions))
			<h6>Questions ({{count($exam->questions)}}):</h6>
				<ul>
					@foreach($exam_questions as $question)
						<li>
							<a href="{{route('exam view question', [$exam->id, $question->id])}}">
								{{$question->quiz_question}}
								@if(count($question->answers) && !$question->answers->where('correct_answer', 1)->first())<span style="color: orange;"><i class="fas fa-exclamation-circle"></i> No correct answer!</span>
								@elseif(!count($question->answers))
									<span style="color: orange;"><i class="fas fa-exclamation-circle"></i> No associated answers!</span>
								@endif
							</a>
						</li>
					@endforeach
				</ul>

				{{$exam_questions->links()}}
				<small>Showing {{($exam_questions->currentpage()-1)*$exam_questions->perpage()+1}} to {{$exam_questions->currentpage()*$exam_questions->perpage()}} of  {{$exam_questions->total()}} entries</small>
			@else
				<p style="margin:0;">You have not created any questions.</a></p>
			@endif
		</div>
	</div>

	<hr>

	<div id="buttons">
		<button type="button" class="btn btn-primary" id="addQuestionBtn">Add Question <i class="fas fa-plus"></i></button>
	</div>

@endsection

@section('scripts')

	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script>
		$(document).ready(function () {

			$(document).on('click', '#editExamBtn', function () {
				$('#editExamBtn').hide();
				$('#title').html('\
					<input type="text" class="form-control" value="'+$("#examNameVal").val()+'" id="examName" placeholder="Exam Title" />\
					<textarea class="form-control" placeholder="Exam Description" id="examDescription">'+$("#examDescriptionVal").val()+'</textarea>\
					<button id="cancelEditExam"><i class="fas fa-times"></i> Cancel</button>\
					<button id="saveEditExam">Save Details</button>\
					');
			});

			$(document).on('click', '#cancelEditExam', function () {
				$('#title').load(window.location + ' #title');
				$('#editExamBtn').show();
			});

			$(document).on('click', '#saveEditExam', function () {
				$(this).attr('disabled', true);
				$(this).html('Please wait..');

				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				$.ajax({
					url: "{{route('exams update')}}",
					method: 'post',
					data: {
						exam_id: {{$exam->id}},
						exam_name: $('#examName').val(),
						exam_description: $('#examDescription').val()
					},
					success: function () {
						$('#title').load(window.location + ' #title');
						$('#editExamBtn').show();
					}
				});
			});

			$(document).on('click', '#addQuestionBtn', function () {
				$(this).hide();
				$('#buttons').append('\
					<input type="text" class="form-control" style="margin-bottom:10px;" name="quiz_question" id="quizQuestion" placeholder="Enter Question.." autocomplete="off" />\
					<button type="button" class="btn btn-success" id="submitAddQuestionBtn">Submit</button>\
					<button type="button" class="btn btn-outline-info" id="cancelAddQuestionBtn">Cancel</button>\
					');
			});

			$(document).on('click', '#cancelAddQuestionBtn', function () {
				$(this).remove();
				$('#submitAddQuestionBtn').remove();
				$('#quizQuestion').remove();
				$('#addQuestionBtn').show();
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
					url: "{{route('exam add question')}}",
					method: 'post',
					data: {
						exam_id: {{$exam->id}},
						quiz_question: $('#quizQuestion').val()
					},
					success: function () {
						$('#submitAddQuestionBtn').remove();
						$('#quizQuestion').remove();
						$('#questions').load(location.href + ' #questions');
						$('#addQuestionBtn').show();
						$('#cancelAddQuestionBtn').remove();
					}
				});
			});

		});
	</script>

@endsection