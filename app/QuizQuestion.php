<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    protected $fillable = ['quiz_exam', 'quiz_question'];

	public function answers()
	{
		return $this->hasMany(QuizAnswer::class, 'quiz_question', 'id');
	}
}
