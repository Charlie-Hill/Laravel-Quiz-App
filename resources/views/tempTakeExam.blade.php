@extends('layouts.main_layout')

@section('title', 'Exam - ' . $exam->exam_name)

@section('content')

	<h2>{{$exam->exam_name}}</h2>
	@if($exam->exam_timelimit != 0)
		<h4 style="margin-bottom:0;">You have {{$exam->exam_timelimit}} minutes to complete this exam.</h4>
		<p style="margin-top:10px;">Time remaining: {{date('i:s', $exam->exam_timelimit*60)}}</p>
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
								<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="{{$answer->id}}">
								<label class="form-check-label" for="{{$answer->id}}">{{$answer->quiz_answer}}</label>
							</div>
						</li>
					@endforeach
				</ul>
			</li>
			<br>
		@endforeach
	</ul>

@endsection