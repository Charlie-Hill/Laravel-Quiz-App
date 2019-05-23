<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = [];

    public function exams()
    {
        $this->hasMany(QuizExam::class, 'group', 'id');
    }

}
