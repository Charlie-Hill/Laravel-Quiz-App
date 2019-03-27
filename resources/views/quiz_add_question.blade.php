<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Add Quiz Question</title>
</head>
<body>
	
	<form method="post">
		@csrf
		<input type="text" name="quiz_question" placeholder="Enter a question" autocomplete="off">
		<button>Submit</button>
	</form>

</body>
</html>