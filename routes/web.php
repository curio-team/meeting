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

//Calendar
Route::get('/', 'CalendarController@show')->name('home');
Route::get('/calendar/json', 'CalendarController@json')->name('calendar.json');

//Suggestion
Route::resource('suggestions', 'SuggestionController', ['except' => 'show']);
Route::get('/suggestions/{suggestion}/ignore/schoolyears/{schoolyear}', 'SuggestionController@ignore')->name('suggestions.ignore');
Route::get('/suggestions/{suggestion}/add/meetings/{meeting}', 'SuggestionController@add')->name('suggestions.add');

//Schoolyears
Route::resource('schoolyears', 'SchoolyearController');
Route::get('schoolyears/{schoolyear}/weeks', 'WeekController@show')->name('schoolyears.weeks.show');
Route::post('schoolyears/{schoolyear}/weeks', 'WeekController@store')->name('schoolyears.weeks.store');

//Meetings
Route::resource('schoolyears.weeks.meetings', 'MeetingController', ['except' => 'index']);
Route::get('schoolyears/{schoolyear}/weeks/{week}/meetings/{meeting}/agenda/edit', 'MeetingController@agenda_edit')->name('schoolyears.weeks.meetings.agenda.edit');
Route::post('schoolyears/{schoolyear}/weeks/{week}/meetings/{meeting}/agenda/save', 'MeetingController@agenda_save')->name('schoolyears.weeks.meetings.agenda.save');

//Minute
Route::get('schoolyears/{schoolyear}/weeks/{week}/meetings/{meeting}/minute', 'MinutController@show')->name('schoolyears.weeks.meetings.minute');

//Topics
Route::resource('schoolyears.weeks.meetings.topics', 'TopicController', ['only' => ['create', 'store']]);
Route::get('schoolyears/{schoolyear}/weeks/{week}/meetings/{meeting}/topics/add', 'TopicController@add')->name('schoolyears.weeks.meetings.topics.add');
Route::post('schoolyears/{schoolyear}/weeks/{week}/meetings/{meeting}/topics/associate', 'TopicController@associate')->name('schoolyears.weeks.meetings.topics.associate');

