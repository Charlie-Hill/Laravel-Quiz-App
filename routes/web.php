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

Route::get('/exams', 'ExamController@index')->name('exams index');
Route::get('/exams/view/{id}', 'ExamController@viewExam')->name('exams view exam');

Route::get('/exams/add', 'ExamController@addExam')->name('exams add exam');
Route::post('/exams/add', 'ExamController@handleAddExam');

Route::post('/exams/questions/add', 'QuizController@handleAddQuizQuestionToExam')->name('quiz exam add question');

Route::get('/quiz', 'QuizController@index')->name('quiz index');
Route::get('/quiz/questions/view/{id}', 'QuizController@viewQuizQuestion')->name('quiz view question');
Route::get('/quiz/add', 'QuizController@addQuizQuestion')->name('quiz add question');
Route::post('/quiz/add', 'QuizController@handleAddQuizQuestion');
Route::post('/quiz/questions/answers/add', 'QuizController@addAnswerToQuestion')->name('quiz add answer');
Route::post('/quiz/questions/answers/correct/update', 'QuizController@changeCorrectAnswerForQuestion')->name('quiz change correct answer');
Route::post('/quiz/questions/answers/remove', 'QuizController@deleteAnswerFromQuestion')->name('quiz delete answer');

Route::post('/quiz/questions/remove', 'QuizController@deleteQuestionFromExam')->name('delete question');