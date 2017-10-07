<?php

use Illuminate\Http\Request;

Auth::routes();

Route::get('/', 'PostController@index')->name('home');

//Posts
Route::post('post/destroyAll', 'PostController@destroyAll')->name('post.destroyAll');
Route::get('post/pdf/{user_id}', 'PostController@exportPdf')->name('post.exportPdf');
Route::resource('post', 'PostController');

// Comments
Route::resource('comment', 'CommentController');

// User Panel
Route::group(['prefix'=>'users'], function(){
	Route::get('/','UserController@index')->name('user.index');
	Route::get('/notifications', 'UserController@notifications')->name('user.notifications');
	Route::get('/posts', 'PostController@manage')->name('post.manage');
	Route::get('/notifications/read/{id}', 'UserController@readNotification')->name('user.readNotification');
	Route::delete('/notifications/{id}', 'UserController@deleteNotification')->name('user.deleteNotification');
	Route::get('/profile', 'UserController@profile')->name('user.profile');
	Route::patch('/profile', 'UserController@updateProfile')->name('user.updateProfile');

	Route::get('/create-user', 'UserController@newUser')->name('user.newUser');
	Route::post('/create-user', 'UserController@createUser')->name('user.createUser');

	Route::get('/confirm-user-post', 'UserController@listUserPostToConfirm')->name('user.userPost')->middleware('role:post-admin|superadministrator');
	Route::get('/confirm-user-post/{id}', 'UserController@userPostConfirm')->name('user.userPostConfirm')->middleware('role:post-admin|superadministrator');

	Route::get('/backup/{id}', 'UserController@backup')->name('user.backup');
	Route::post('/restore/', 'UserController@restore')->name('user.restore');
});

// Admin Panel
Route::group(['namespace'=>'Admin', 'prefix'=>'admin', 'middleware'=>'role:superadministrator'], function(){
	Route::get('/', 'HomeController@index')->name('admin.index');
	Route::get('/manage-posts', 'PostController@managePosts')->name('admin.managePost');
	Route::get('/confirm-post/{id}', 'PostController@confirmPost')->name('admin.ConfirmPost');
});

// Auth Socials
Route::group(['prefix'=>'auth'], function(){
	Route::get('/google', 'SocialController@redirectToProvider')->name('auth.googleLogin');
	Route::get('/google/redirect', 'SocialController@handleProviderCallback');
});

// Authentication with Passport
Route::get('/auth-test',function (){
	$query = http_build_query([
		'client_id'=>3,
		'redirect_uri'=>'http://127.0.0.1:8000/callback',
		'response_type'=>'code',
		'scope'=>''
	]);

	return redirect('http://127.0.0.1:8000/oauth/authorize?'.$query);
});
Route::get('/callback', function (Request $request) {
	$http = new GuzzleHttp\Client;

	$response = $http->post('http://127.0.0.1:8000/oauth/token', [
		'form_params' => [
			'grant_type' => 'authorization_code',
			'client_id' => '3',
			'client_secret' => 'sG4mJNHrYlXhY8cg7rBoiUrqaPkvxFUWth3SK1jo',
			'redirect_uri' => 'http://127.0.0.1:8000/callback',
			'code' => $request->code,
		],
	]);

	return json_decode((string) $response->getBody(), true);
});