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

Route::resource('schoolyears.weeks.meetings', 'MeetingController', ['except' => 'index']);
Route::resource('schoolyears.weeks.meetings.topics', 'TopicController', ['only' => ['create', 'store']]);
Route::get('schoolyears/{schoolyear}/weeks/{week}/meetings/{meeting}/topics/add', 'TopicController@add')->name('schoolyears.weeks.meetings.topics.add');
Route::post('schoolyears/{schoolyear}/weeks/{week}/meetings/{meeting}/topics/associate', 'TopicController@associate')->name('schoolyears.weeks.meetings.topics.associate');

