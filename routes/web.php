<?php

Route::get('/', 'HomeController@index')->middleware('auth');
Route::get('/home', 'HomeController@index')->middleware('auth');

// chat routes
Route::get('/messages', 'ChatController@chat')->middleware('auth');
Route::get('/chat/{chat_id}', 'ChatController@chat')->middleware('auth');
Route::post('/chat/{chat_id}', 'ChatController@getMsg')->middleware('auth');
Route::get('/chat/user/{user_id}', 'ChatController@chatUser')->middleware('auth');
Route::post('/message/sendMsg', 'MessageController@new')->middleware('auth');
Route::get('/message/sendMsg', 'MessageController@new')->middleware('auth');
Route::post('/unsen_messages', 'MessageController@unseen')->middleware('auth');
Route::post('/msgSeen/{message_id}','MessageController@markSeen')->middleware('auth');

// user routs
Route::get('/profile/{id}', 'UserController@index')->middleware('auth');
Route::get('/edit_profile', 'UserController@change')->middleware('auth');
Route::post('/profile/save_changes', 'UserController@saveChanges')->middleware('auth');

// friends routes
Route::get('/friends', 'FriendController@index')->middleware('auth');
Route::get('/find_friends', 'FriendController@find')->middleware('auth');
Route::post('/add_friend', 'FriendController@friend_request')->middleware('auth');
Route::post('/remove_friend', 'FriendController@remove')->middleware('auth');
Route::get('/friend_requests', 'FriendController@requests_list')->middleware('auth');
Route::post('/except_friend', 'FriendController@except')->middleware('auth');

Auth::routes();

View::composer(['*'], function($view){
	if (!empty(Auth::user())) {
		$user = Auth::user();
		$view->with('unseenFriendRequests', 
			App\FriendRequest::where('receiver', $user->id)
				->where('seen', false)->get()
		);
	}
});