<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\QuizQuestion;
use App\QuizAnswer;
use App\QuizExam;

class QuizController extends Controller
{
	// public function index()
	// {
	// 	$questions = QuizQuestion::get();
	// 	return view('quiz_index')->with(['questions' => $questions]);
	// }

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

	public function handleAddQuizQuestionToExam(Request $request)
	{
		if(!$request->ajax()) return response('Forbidden.', 403);

		$validatedData = $request->validate([
			'exam_id' => 'required',
			'quiz_question' => 'required|max:255'
		]);

		$exam = QuizExam::find(request('exam_id'));

		QuizQuestion::create([
			'quiz_exam' => $exam->id,
			'quiz_question' => request('quiz_question')
		]);

		return response()->json(['success' => 'Data is successfully added']);
	}

	public function addAnswerToQuestion(Request $request)
	{
		if(!$request->ajax()) return response('Forbidden.', 403);

		$validatedData = $request->validate([
			'answer' => 'required|max:255',
			'question_id' => 'required'
		]);

		if(request('correct_answer') == 1) {
			QuizAnswer::where('quiz_question', request('question_id'))->where('correct_answer', 1)->update(['correct_answer' => 0]);
		}

		QuizAnswer::create([
			'quiz_question' => request('question_id'),
			'quiz_answer' => request('answer'),
			'correct_answer' => request('correct_answer')
		]);

		return response()->json(['success'=>'Data is successfully added']);
	}

	public function changeCorrectAnswerForQuestion(Request $request)
	{
		if(!$request->ajax()) return response('Forbidden.', 403);

		$answer = request('answer_id');

		QuizAnswer::where('quiz_question', request('question_id'))->where('correct_answer', 1)->update(['correct_answer' => 0]);
		QuizAnswer::find($answer)->update(['correct_answer' => 1]);

		return response()->json(['success' => 'Data is successfully changed']);
	}

	public function deleteAnswerFromQuestion(Request $request)
	{
		if(!$request->ajax()) return response('Forbidden.', 403);

		$question = request('question_id');
		$answer = request('answer_id');

		$answer = QuizAnswer::destroy($answer);

		return response()->json(['success'=>'Data is successfully removed']);
	}
}
