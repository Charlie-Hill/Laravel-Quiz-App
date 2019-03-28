@extends('layouts.main_layout')

@section('title', 'Exam - ' . $exam->exam_name)

@section('content')

	<h2>{{$exam->exam_name}}</h2>
	@if($exam->exam_timelimit != 0)
		<h4 style="margin-bottom:0;">You have {{$exam->exam_timelimit}} minutes to complete this exam.</h4>
		<p style="margin-top:10px;">Time remaining: <span id="timeRemaining">{{date('i:s', ($exam->exam_timelimit*60))}}</span></p>
	@endif
	<a href="{{route('exams index')}}"><i class="fas fa-arrow-left"></i> Back</a>
	<hr>

	<ul>
		@foreach($question_pool as $index => $question)
			<li>{{$index+1}}.) {{$question->quiz_question}}
				<ul>
					@foreach($question->answers()->inRandomOrder()->distinct()->get() as $answer)
						<li>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="{{$index}}" id="{{$answer->id}}" value="{{$answer->id}}">
								<label class="form-check-label">{{$answer->quiz_answer}}</label>
							</div>
						</li>
					@endforeach
				</ul>
			</li>
			<br>
		@endforeach
	</ul>

@endsection

@section('scripts')
	<script>
		$(document).ready(function() {
			var startTime = $('#timeRemaining').html();
			setInterval(function() {
				var timer = startTime.split(':');
				var minutes = parseInt(timer[0], 10);
				var seconds = parseInt(timer[1], 10);
				--seconds;
				minutes = (seconds < 0) ? --minutes : minutes;
				seconds = (seconds < 0) ? 59 : seconds;
				seconds = (seconds < 10) ? '0' + seconds : seconds;
				$('#timeRemaining').html(minutes + ':' + seconds);
				if (minutes < 0) clearInterval(interval);
				//check if both minutes and seconds are 0
				if ((seconds <= 0) && (minutes <= 0)) clearInterval(interval);
				startTime = minutes + ':' + seconds;
			}, 1000);
		})
	</script>
@endsection