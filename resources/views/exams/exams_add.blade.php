<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Quiz Create Exam</title>
</head>
<body>
	
	<h4>Create Exam</h4>

	@if($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
	@endif

	<form method="post">
		@csrf
		<input type="text" name="exam_name" placeholder="Exam Name" /><br>
		<textarea name="exam_description" placeholder="Exam Description"></textarea><br>
		<select name="exam_timelimit">
			<option value="0">No Limit</option>
			<option value="10">10 minutes</option>
			<option value="15">15 minutes</option>
			<option value="30">30 minutes</option>
			<option value="45">45 minutes</option>
			<option value="60">60 minutes</option>
		</select>
		<button type="submit">Submit</button>
	</form>

</body>
</html>