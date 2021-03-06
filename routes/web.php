<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return redirect(route('exams index'));
});

/* Groups management */
Route::get('/groups', function () {
    $exam = \App\QuizExam::find(6);

    return $exam->group()->title;
});
/* Groups management */

/* Exam management */
Route::get('/exams', 'ExamController@index')->name('exams index');
Route::get('/exams/view/{id}', 'ExamController@viewExam')->name('exams view exam');
Route::get('/exams/add', 'ExamController@addExam')->name('exams add exam');
Route::post('/exams/add', 'ExamController@handleAddExam');
Route::post('/exams/update', 'ExamController@handleUpdateExam')->name('exams update');
Route::post('/exams/remove', 'ExamController@handleRemoveExam')->name('exam remove exam');

Route::get('/exams/take/{id}', 'ExamController@takeExam')->name('exams take exam');
Route::post('/exams/take/{id}', 'ExamController@submitExam')->name('exams submit exam');
/* Exam management */

/* Exam questions management */
Route::get('/exams/{examid}/questions/{questionid}', 'QuestionController@viewExamQuestion')->name('exam view question');
Route::post('/exams/questions/add', 'QuestionController@handleAddQuestionToExam')->name('exam add question');
Route::post('/exams/questions/remove', 'QuestionController@handleDeleteQuestionFromExam')->name('exam delete question');
/* Exam questions management */

/* Exam answers management */
Route::post('/exams/questions/answers/add', 'AnswerController@handleAddAnswerToQuestion')->name('exam question add answer');
Route::post('/exams/questions/answers/updateCorrectAnswer', 'AnswerController@handleUpdateCorrectAnswer')->name('exam question answer updateCorrect');
Route::post('/exams/questions/answers/remove', 'AnswerController@handleDeleteAnswerFromQuestion')->name('exam question delete answer');
/* Exam answers management */

Route::get('/home', 'HomeController@index')->name('home');
