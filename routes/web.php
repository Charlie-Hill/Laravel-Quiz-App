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
    return view('welcome');
});

Route::get('/quiz', 'QuizController@index')->name('quiz index');
Route::get('/quiz/questions/view/{id}', 'QuizController@viewQuizQuestion')->name('quiz view question');

Route::get('/quiz/add', 'QuizController@addQuizQuestion')->name('quiz add question');
Route::post('/quiz/add', 'QuizController@handleAddQuizQuestion');

Route::post('/quiz/questions/answers/add', 'QuizController@addAnswerToQuestion')->name('quiz add answer');
Route::post('/quiz/questions/answers/correct/update', 'QuizController@changeCorrectAnswerForQuestion')->name('quiz change correct answer');
Route::post('/quiz/questions/answers/remove', 'QuizController@deleteAnswerFromQuestion')->name('quiz delete answer');