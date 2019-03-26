<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Quiz View Question</title>

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

	<h2>Q. {{$question->quiz_question}}</h2>
	<a href="{{route('quiz index')}}"><span class="fas fa-arrow-left"></span> Back</a>

	<hr>

	<div id="answers">
		
		@if(count($question->answers))
			<ul>
				@foreach($question->answers as $answer)
					<li>
						<span style="{{$answer->correct_answer ? "color: green;" : ""}};">{{$answer->quiz_answer}} @if($answer->correct_answer == 1)| <i class="fas fa-check"></i> Correct Answer!@endif <button class="no-border deleteBtn" data-answer-id="{{$answer->id}}"><i class="fas fa-trash"></i></button></span>
					</li>
				@endforeach
			</ul>
		@else
			<p>There are answers associated with this question yet.</p>
		@endif

	</div>

	<button type="button" id="addAnswerBtn">Add Answer <i class="fas fa-plus"></i></button>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script>
		$(document).ready(function () {
			$(document).on('click', '#addAnswerBtn', function () {

				$('#addAnswerBtn').hide();
				$('#answers').append('\
					<input type="text" name="answer" id="addAnswerInp" placeholder="Enter the answer" />\
					<input type="checkbox" id="correct_answer" value="0"> Correct Answer<br> \
					<button type="submit" id="submitAnswerBtn">Submit</button>\
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

			$(document).on('click', '.deleteBtn', function () {
				var result = confirm("Are you sure you want to delete this answer?");

				console.log($(this).data('answer-id'));

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
					})					
				}
			});
		});
	</script>
	
</body>
</html>