@extends('layouts.main_layout')

@section('title', 'View Question')

@section('content')
	<h2>Q. {{$question->quiz_question}}</h2>
	<a href="{{route('exams view exam', $question->quiz_exam)}}"><span class="fas fa-arrow-left"></span> Back</a>

	<hr>

	<div id="answers" class="col-lg-12">
		
		@if(count($question->answers))
			<ul>
				@foreach($question->answers as $answer)
					<li>
						<span style="{{$answer->correct_answer ? "color: green;" : ""}};">{{$answer->quiz_answer}} @if($answer->correct_answer == 1)| <i class="fas fa-check"></i> Correct Answer!@endif <button class="no-border deleteBtn" data-answer-id="{{$answer->id}}"><i class="fas fa-trash"></i></button> @if(!$answer->correct_answer)<button class='no-border selectCorrectBtn' data-answer-id="{{$answer->id}}"><i class='fas fa-check'></i></button>@endif</span>
					</li>
				@endforeach
			</ul>
		@else
			<p>There are answers associated with this question yet.</p>
		@endif

	</div>

	<button type="button" class="btn btn-primary" id="addAnswerBtn">Add Answer <i class="fas fa-plus"></i></button>

@endsection

@section('scripts')
	<script>
		$(document).ready(function () {
			$(document).on('click', '#addAnswerBtn', function () {

				$('#addAnswerBtn').hide();
				$('#answers').append('\
					<input type="text" name="answer" class="form-control" id="addAnswerInp" placeholder="Enter the answer" autocomplete="off" />\
					<input type="checkbox" id="correct_answer" value="0"> Correct Answer<br> \
					<button type="button" class="btn btn-primary" id="submitAnswerBtn">Submit</button>\
					');

			});

			$(document).on('click', '#submitAnswerBtn', function () {
				$('#submitAnswerBtn').attr('disabled', true);
				$('#submitAnswerBtn').html('Please Wait..');

				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				$.ajax({
					url: "{{route('quiz add answer')}}",
					method: 'post',
					data: {
						answer: $('#addAnswerInp').val(),
						correct_answer: $('#correct_answer').is(':checked')  ? '1' :'0',
						question_id: {{$question->id}}
					},
					success: function () {
						$('#submitAnswerBtn').hide();
						$('#answers').load(location.href + ' #answers');
						$('#addAnswerBtn').show();
					}
				});
			});

			$(document).on('click', '.selectCorrectBtn', function () {
				var result = confirm("Are you sure you want to change the correct answer for this question?");

				if(result)  {
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});
					$.ajax({
						url: "{{route('quiz change correct answer')}}",
						method: 'post',
						data: {
							question_id: {{$question->id}},
							answer_id: $(this).data('answer-id')
						},
						success: function () {
							$('#answers').load(location.href + ' #answers');
						}
					});
				}
			});

			$(document).on('click', '.deleteBtn', function () {
				var result = confirm("Are you sure you want to delete this answer?");

				if(result) {
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});
					$.ajax({
						url: "{{route('quiz delete answer')}}",
						method: 'post',
						data: {
							question_id: {{$question->id}},
							answer_id: $(this).data('answer-id')
						},
						success: function () {
							$('#answers').load(location.href + ' #answers');
						}
					});
				}
			});
		});
	</script>
@endsection