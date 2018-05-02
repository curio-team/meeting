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

//Suggestions
Route::resource('suggestions', 'SuggestionController', ['except' => 'show']);
Route::get('/suggestions/{suggestion}/ignore/schoolyears/{schoolyear}', 'SuggestionController@ignore')->name('suggestions.ignore');
Route::post('/suggestions/{suggestion}/meetings', 'SuggestionController@attach')->name('suggestions.attach');

//Schoolyears
Route::resource('schoolyears', 'SchoolyearController');
Route::get('schoolyears/{schoolyear}/weeks', 'WeekController@show')->name('schoolyears.weeks.show');
Route::post('schoolyears/{schoolyear}/weeks', 'WeekController@store')->name('schoolyears.weeks.store');

//Meetings
Route::resource('schoolyears.weeks.meetings', 'MeetingController', ['except' => 'index']);

//Meetings.Listings
Route::get('meetings/{meeting}/listings/edit', 'MeetingController@agenda_edit')->name('meetings.listings.edit');
Route::patch('meetings/{meeting}/listings', 'MeetingController@agenda_update')->name('meetings.listings.update');

//Meetings.Topics
Route::post('meetings/{meeting}/topics', 'MinuteControllerBackground@store_topic')->name('meetings.topics.store');

//Minute
Route::get('meetings/{meeting}/minutes/start', 'MinuteControllerShow@start')->name('meetings.minute.start');
Route::get('meetings/{meeting}/minutes/listing/{listing}', 'MinuteControllerShow@item')->name('meetings.minute.listing');
Route::get('meetings/{meeting}/minutes/end', 'MinuteControllerShow@end')->name('meetings.minute.end');

//Topics
Route::resource('schoolyears.weeks.meetings.topics', 'TopicController', ['only' => ['create', 'store']]);
Route::get('schoolyears/{schoolyear}/weeks/{week}/meetings/{meeting}/topics/add', 'TopicController@add')->name('schoolyears.weeks.meetings.topics.add');
Route::post('schoolyears/{schoolyear}/weeks/{week}/meetings/{meeting}/topics/associate', 'TopicController@associate')->name('schoolyears.weeks.meetings.topics.associate');
Route::post('topics/{topic}/close', 'TopicController@close')->name('topics.close');

//Tasks
Route::post('tasks/{task}/state', 'TaskController@change_state')->name('tasks.state');
Route::post('topics/{topic}/tasks', 'TaskController@store_with_topic')->name('topics.tasks.store');

//Comments
Route::post('topics/{topic}/comments', 'CommentController@store_topic')->name('topics.comments.store');
Route::post('tasks/{task}/comments', 'CommentController@store_task')->name('tasks.comments.store');

//Listings
Route::post('listings/{listing}/meetings', 'ListingController@attach')->name('listings.attach');

