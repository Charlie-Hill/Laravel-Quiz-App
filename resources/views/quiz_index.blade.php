<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Quiz Index</title>
</head>
<body>
	
	<h4>Questions</h4>

	<ul>
	@foreach($questions as $question)
		<li>
			<a href="{{route('quiz view question', $question->id)}}">{{$question->quiz_question}}</a>
		</li>
	@endforeach
	</ul>
	
	<br>

	<a href="{{route('quiz add question')}}">Add new quiz question</a>

</body>
</html>