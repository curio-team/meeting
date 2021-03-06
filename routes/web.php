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

Route::group(['middleware' => ['auth', 'teacher']], function() {

//Search
Route::get('search', 'SearchController@show')->name('search');
Route::post('search/titles', 'SearchController@titles')->name('search.titles');
Route::post('search/slug', 'SearchController@slug')->name('search.slug');

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

//Events
Route::resource('schoolyears.weeks.events', 'EventController', ['except' => ['index', 'show']]);

//Meetings.Listings
Route::get('meetings/{meeting}/listings/edit', 'MeetingController@agenda_edit')->name('meetings.listings.edit');
Route::patch('meetings/{meeting}/listings', 'MeetingController@agenda_update')->name('meetings.listings.update');
Route::delete('meetings/{meeting}/listings', 'ListingController@destroy')->name('meetings.listings.delete');
Route::get('meetings/{meeting}/listings/create', 'ListingController@create')->name('meetings.listings.create');

//Meetings.Topics
Route::post('meetings/{meeting}/topics', 'MinuteController@store_topic')->name('meetings.topics.store');
Route::patch('meetings/{meeting}/topics', 'TopicController@attach')->name('meetings.topics.attach');

//Meetings.Tasks
Route::patch('meetings/{meeting}/tasks', 'TaskController@attach')->name('meetings.tasks.attach');

//Minute
Route::get('meetings/{meeting}/minutes/claim', 'MinuteController@claim_show')->name('meetings.minutes.claim.show');
Route::post('meetings/{meeting}/minutes/claim', 'MinuteController@claim')->name('meetings.minutes.claim');
Route::get('meetings/{meeting}/minutes/start', 'MinuteController@start')->name('meetings.minutes.start');
Route::get('meetings/{meeting}/minutes/listings/{listing}', 'MinuteController@item')->name('meetings.minutes.listing');
Route::post('meetings/{meeting}/minutes/listings/{listing}/next', 'MinuteController@next')->name('meetings.minutes.listing.next');
Route::get('meetings/{meeting}/minutes/questions', 'MinuteController@questions')->name('meetings.minutes.questions');
Route::post('meetings/{meeting}/minutes/close', 'MinuteController@close')->name('meetings.minutes.close');

//Topics
Route::get('topics/{topic}', 'TopicController@show')->name('topics.show');
Route::resource('schoolyears.weeks.meetings.topics', 'TopicController', ['only' => ['create', 'store']]);
Route::post('topics/{topic}/close', 'TopicController@close')->name('topics.close');
Route::post('topics/{topic}/reopen', 'TopicController@reopen')->name('topics.reopen');

//Tasks
Route::get('tasks/{task}', 'TaskController@show')->name('tasks.show');
Route::post('tasks/{task}/state', 'TaskController@change_state')->name('tasks.state');
Route::post('topics/{topic}/tasks', 'TaskController@store_with_topic')->name('topics.tasks.store');

//Comments
Route::post('topics/{topic}/comments', 'CommentController@store_topic')->name('topics.comments.store');
Route::post('tasks/{task}/comments', 'CommentController@store_task')->name('tasks.comments.store');
Route::get('comment/{comment}/edit', 'CommentController@edit')->name('comments.edit');
Route::put('comment/{comment}', 'CommentController@update')->name('comments.update');

//Listings
Route::post('listings/{listing}/meetings', 'ListingController@attach')->name('listings.attach');

});

//Login
Route::get('/amoclient/ready', function(){
	return redirect()->route('home');
});
Route::get('/login', function(){
	return redirect('/amoclient/redirect');
})->name('login');


// \DB::listen(function($sql) {
//     var_dump($sql->sql);
//     echo '<br />';
// });