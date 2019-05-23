<?php

namespace App\Http\Controllers;


use App\QuizExam;
use App\ExamResult;
use App\QuizAnswer;
use App\Group;
use App\QuizQuestion;

use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $category = null;
        if(!empty($_GET['category'])) {
            $category = Group::where('title', $_GET['category'])->first();
            $exams = QuizExam::where('group_id', $category->id)->get();
        } else {
            $exams = QuizExam::orderBy('group_id')->get();
        }
    	return view('exams.exams_index')->with([
            'exams' => $exams,
            'category' => $category
            ]);
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
        if(!$request->ajax()) return response(['Forbidden.', 403]);

		$validatedData = $request->validate([
			'exam_name' => 'required|max:60',
			'exam_description' => 'required|max:255'
		]);

		QuizExam::create($request->all());

        return response(['success' => 'Data is successfully added']);
    }

    public function handleUpdateExam(Request $request)
    {
        if(!$request->ajax()) return response(['Forbidden.', 403]);

        $exam = QuizExam::find(request('exam_id'));
        $exam->update(['exam_name' => request('exam_name'), 'exam_description' => request('exam_description')]);

        return response()->json(['success' => 'Data is successfully removed']);
    }

    public function handleRemoveExam(Request $request)
    {
        if(!$request->ajax()) return response(['Forbidden', 403]);

        QuizExam::destroy(request('exam_id'));

        return response(['success' => 'Data is successfully removed']);
    }

    public function takeExam($id)
    {
        $exam = QuizExam::find($id);

        $questions = $exam->getQuestionsWithAnswers($exam->questions->count());

        return view('tempTakeExam')
                ->with(['exam' => $exam, 'questions' => $questions]);
    }

    public function submitExam(Request $request)
    {
        $questions = array();
        for($i = 0; $i < request('num_questions'); $i++) {
            $questions[] = list($question, $answer) = array(request('question_'.$i), request('answer_'.$i));
        }

        $correctCount = 0;

        // tmp
        $examId = 0;
        foreach($questions as $question)
        {
            $dbQuestion = QuizQuestion::find($question[0]);
            $dbAnswer = QuizAnswer::find($question[1]);

            if(!$dbQuestion || !$dbAnswer) continue;

            $examId = $dbQuestion->quiz_exam;

            // No need to query QuizAnswers twice. Select both once -> filter by correct_answer when displaying them
            $otherAnswers = QuizAnswer::where('quiz_question', $dbQuestion->id)->where('id', '!=', $dbAnswer->id)->get();

            $correct = false;
            if($dbAnswer->correct_answer == 1) {
                $correct = true;
                $correctCount++;
            }

            $string = "";
            foreach($otherAnswers as $otherAnswer) {
                $string = $string. "<br /><span style='color: grey;'>A.) ".$otherAnswer->quiz_answer."</span>";
            }

            print("Q.) " . $dbQuestion->quiz_question . "<br /><span style='margin-left:40px;'>A.) " . $dbAnswer->quiz_answer . " <b>" . ($correct ? '✓ correct' : 'X incorrect') . "</b>".$string."</span><br /><br />");
        }

        ExamResult::create([
            'exam_id' => $examId,
            'correct_answers' => $correctCount
        ]);

        $percentageScore = ($correctCount / count($questions)) * 100;

        print("<hr>You scored: " . $correctCount . "/" . count($questions) . "(" . round($percentageScore, 2) . "%)
                <a href='/exams/view/".$dbQuestion->quiz_exam."'><-- Back</a>
            ");
    }
}
