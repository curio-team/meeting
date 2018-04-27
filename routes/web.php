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

Route::get('/', 'CalendarController@show')->name('home');
Route::get('/calendar/json', 'CalendarController@json')->name('calendar.json');

Route::resource('schoolyears', 'SchoolyearController');

Route::get('schoolyears/{schoolyear}/weeks', 'WeekController@show')->name('schoolyears.weeks.show');
Route::post('schoolyears/{schoolyear}/weeks', 'WeekController@store')->name('schoolyears.weeks.store');

// Route::get('schoolyears/{schoolyear}/meetings/batch', 'MeetingCreateController@batch_create')->name('schoolyear.meetings.batch_create');
// Route::post('schoolyears/{schoolyear}/meetings/batch', 'MeetingCreateController@batch_store')->name('schoolyear.meetings.batch_store');
// Route::get('schoolyears/{schoolyear}/meetings/create', 'MeetingCreateController@create')->name('schoolyear.meetings.batch_create');
// Route::post('schoolyears/{schoolyear}/meetings/create', 'MeetingCreateController@store')->name('schoolyear.meetings.batch_store');
Route::resource('schoolyears.meetings', 'MeetingController', ['except' => 'index']);