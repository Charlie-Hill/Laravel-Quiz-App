<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\QuizExam;

class ExamController extends Controller
{
    public function index()
    {
    	$exams = QuizExam::get();
    	return view('exams.exams_index')->with(['exams' => $exams]);
    }

    public function viewExam($id)
    {
        $exam = QuizExam::find($id);
        $exam_questions = $exam->questions()->paginate(10);
        return view('exams.exams_view')->with(['exam' => $exam, 'exam_questions' => $exam_questions]);
    }

    public function addExam()
    {
    	return view('exams.exams_add');
    }

    public function handleAddExam(Request $request)
    {
		$validatedData = $request->validate([
			'exam_name' => 'required|max:60',
			'exam_description' => 'required|max:255'
		]);

		QuizExam::create($request->all());

		return redirect(route('exams index'));
    }

}
