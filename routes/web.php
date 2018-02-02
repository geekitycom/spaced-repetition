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
    return view('welcome', ['title' => 'Welcome to Learn!']);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get(
    'subjects/{subject}/delete',
    'SubjectController@delete'
)->name('subjects.delete');

Route::resource('subjects', 'SubjectController');

Route::get(
    'subjects/{subject}/questions/{question}/delete',
    'QuestionController@delete'
)->name('subjects.questions.delete');

Route::resource('subjects.questions', 'QuestionController');

Route::get('review', 'ReviewController@index')->name('review.index');
Route::get('review/done', 'ReviewController@done')->name('review.done');
Route::get('review/{question}', 'ReviewController@ask')->name('review.ask');
Route::get('review/{question}/answer', 'ReviewController@answer')->name('review.answer');
Route::post('review/{question}/answer', 'ReviewController@update')->name('review.update');
