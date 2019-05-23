<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/groups/all', function () {
    return Response::json(\App\Group::all());
});

Route::post('/exams/update/group', function (Request $request) {
    $group = $request->group;
    if($group == 0) $group = null;

    $exam = \App\QuizExam::findOrFail($request->exam);
    $exam->update(['group' => $group]);

    if($exam) {
        return 'true';
    } else {
        return 'false';
    }
});
