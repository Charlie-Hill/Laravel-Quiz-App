<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\QuizExam;
use App\QuizQuestion;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function viewExamQuestion($examid, $id)
    {
    	$question = QuizQuestion::find($id);
    	return view('exams.questions.view_exam_question')->with(['question' => $question]);
    }

    public function handleAddQuestionToExam(Request $request)
    {
		if(!$request->ajax()) return response('Forbidden.', 403);

		$validatedData = $request->validate([
			'exam_id' => 'required',
			'quiz_question' => 'required|max:1000'
		]);

		$question = request('quiz_question');
		if(substr($question, -1) != '?') {
			$question = $question . '?';
		}

		$exam = QuizExam::find(request('exam_id'));

		QuizQuestion::create([
			'quiz_exam' => $exam->id,
			'quiz_question' => $question
		]);

		return response()->json(['success' => 'Data is successfully added']);
    }

    public function handleDeleteQuestionFromExam(Request $request)
    {
		if(!$request->ajax()) return response('Forbidden.', 403);

		$question = request('question_id');
		QuizQuestion::destroy($question);

		return response()->json(['success' => 'Data is successfully removed']);
    }
}
