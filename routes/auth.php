<?php

//Post
Route::get('post/create',[
		'uses' => 'CreatePostController@create',
		'as' => 'posts.create'
	]);

Route::post('post/create',[
		'uses' => 'CreatePostController@store',
		'as' => 'posts.store'
	]); 

//Coments
Route::post('posts/{post}/comment',[
		'uses' => 'CommentController@store',
		'as' => 'comments.store'
	]);

Route::post('comments/{comment}/accept',[
		'uses' => 'CommentController@accept',
		'as' => 'comments.accept'
	]);

//Subscriptions 
Route::post('posts/{post}/subscribe',[
		'uses' => 'SubscriptionController@subscribe',
		'as' => 'posts.subscribe'
	]);