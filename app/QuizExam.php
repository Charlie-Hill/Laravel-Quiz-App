<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizExam extends Model
{
    //
    protected $guarded = [];

	public function questions()
	{
		return $this->hasMany(QuizQuestion::class, 'quiz_exam', 'id');
	}

	public function getQuestionsWithAnswers()
	{
		$questions = $this->questions()->inRandomOrder()->distinct()->take(10)->get();
		$finalQuestions = array();

		foreach($questions as $index => $question)
		{
			$answers[$index] = $question->answers()->inRandomOrder()->get();
			$finalQuestions[] = array("question" => $question, "answers" => $answers[$index]);
		}

		return $finalQuestions;
	}

	public function hasQuestions()
	{
		if(count($this->questions) <= 0) {
			return false;
		} else {
			return true;
		}
	}

	public function hasMissingCorrectAnswers()
	{
		$count = 0;

		foreach($this->questions as $question) {
			$answers = $question->answers()->where('correct_answer', '!=', 0)->get();
			if(!count($answers)) {
				$count++;
			}
		}

		if($count != 0) {
			return $count;
		} else {
			return false;
		}
	}
}
