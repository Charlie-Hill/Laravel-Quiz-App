<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Quiz Index</title>
</head>
<body>
	
	<h4>Exams</h4>

	<ul>
{{-- 	@foreach($questions as $question)
		<li>
			<a href="{{route('quiz view question', $question->id)}}">{{$question->quiz_question}}</a>
		</li>
	@endforeach --}}

	@foreach($exams as $exam)

	@endforeach

	</ul>
	
	<br>

	<a href="{{route('exams add exam')}}">Create new exam</a>

	{{-- <a href="{{route('quiz add question')}}">Add new quiz question</a> --}}

</body>
</html>