<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Quiz Exams Index</title>
</head>
<body>
	
	<h4>Exams</h4>

	<ul>
		@foreach($exams as $exam)
			<li>
				<a href="{{route('exams view exam', $exam->id)}}">{{$exam->exam_name}}</a>
			</li>
		@endforeach
	</ul>

	<br>

	<a href="{{route('exams add exam')}}">Create new exam</a>

</body>
</html>