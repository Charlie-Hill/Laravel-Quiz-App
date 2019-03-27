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

Route::get('/', function () {
    return redirect(route('exams index'));
});

/* Exam management/creation */
Route::get('/exams', 'ExamController@index')->name('exams index');
Route::get('/exams/view/{id}', 'ExamController@viewExam')->name('exams view exam');
Route::get('/exams/add', 'ExamController@addExam')->name('exams add exam');
Route::post('/exams/add', 'ExamController@handleAddExam');
/* Exam management/creation */

/* Exam questions management */
// Route::get('/exams/{examid}/questions/', 'QuestionController@viewExamQuestions')->name('exam view questions');
Route::get('/exams/{examid}/questions/{questionid}', 'QuestionController@viewExamQuestion')->name('exam view question');

Route::post('/exams/questions/add', 'QuestionController@handleAddQuestionToExam')->name('exam add question');
Route::post('/exams/questions/remove', 'QuestionController@handleDeleteQuestionFromExam')->name('exam delete question');
/* Exam questions management */

Route::get('/quiz', 'QuizController@index')->name('quiz index');
//Route::get('/quiz/add', 'QuizController@addQuizQuestion')->name('quiz add question');
//Route::post('/quiz/add', 'QuizController@handleAddQuizQuestion');
Route::post('/quiz/questions/answers/add', 'QuizController@addAnswerToQuestion')->name('quiz add answer');
Route::post('/quiz/questions/answers/correct/update', 'QuizController@changeCorrectAnswerForQuestion')->name('quiz change correct answer');
Route::post('/quiz/questions/answers/remove', 'QuizController@deleteAnswerFromQuestion')->name('quiz delete answer');
