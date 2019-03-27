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
}
