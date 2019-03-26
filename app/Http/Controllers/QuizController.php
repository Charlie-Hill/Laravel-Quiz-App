<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\QuizQuestion;
use App\QuizAnswer;

class QuizController extends Controller
{
	public function index()
	{
		$questions = QuizQuestion::get();

		return view('quiz_index')->with(['questions' => $questions]);
	}

	public function viewQuizQuestion($id)
	{
		$question = QuizQuestion::find($id);

		return view('quiz_view_question')->with(['question' => $question]);
	}

	public function addQuizQuestion()
	{
		return view('quiz_add_question');
	}

	public function handleAddQuizQuestion(Request $request)
	{
		$validatedData = $request->validate([
			'quiz_question' => 'required|max:255'
		]);

		$question = request('quiz_question');

		if(substr($question, -1) != '?') {
			$question = $question . '?';
		}

		QuizQuestion::create([
			'quiz_question' => $question
		]);

		return redirect(route('quiz index'));
	}

	public function addAnswerToQuestion(Request $request)
	{
		if(!$request->ajax()) return response('Forbidden.', 403);
		
		\Log::info("THIS IS A DEBUG");
		\Log::info($request);

		$validatedData = $request->validate([
			'answer' => 'required|max:255',
			'question_id' => 'required'
		]);

		$correct_answer = filter_var(request('correct_answer'), FILTER_VALIDATE_BOOLEAN);

		\Log::info('Value of correct_answer ' . $correct_answer);

		if($correct_answer == 1) {
			QuizAnswer::where('quiz_question', request('question_id'))->where('correct_answer', 1)->update(['correct_answer' => 0]);
		}

		QuizAnswer::create([
			'quiz_question' => request('question_id'),
			'quiz_answer' => request('answer'),
			'correct_answer' => $correct_answer
		]);

		return response()->json(['success'=>'Data is successfully added']);
	}
}
