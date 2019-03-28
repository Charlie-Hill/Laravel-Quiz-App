<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\QuizAnswer;

class AnswerController extends Controller
{
    public function handleAddAnswerToQuestion(Request $request)
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

    public function handleUpdateCorrectAnswer(Request $request)
    {
		if(!$request->ajax()) return response('Forbidden.', 403);

		$answer = request('answer_id');

		QuizAnswer::where('quiz_question', request('question_id'))->where('correct_answer', 1)->update(['correct_answer' => 0]);
		QuizAnswer::find($answer)->update(['correct_answer' => 1]);

		return response()->json(['success' => 'Data is successfully changed']);
    }

    public function handleDeleteAnswerFromQuestion(Request $request)
    {
		if(!$request->ajax()) return response('Forbidden.', 403);

		$question = request('question_id');
		$answer = request('answer_id');

		$answer = QuizAnswer::destroy($answer);

		return response()->json(['success'=>'Data is successfully removed']);
    }
}
