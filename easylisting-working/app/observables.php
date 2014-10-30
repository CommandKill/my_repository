<?php

Event::listen('auth.login', function($user)
{
	Debugbar::info($user);
	$log = sprintf('User %s logged in admin system at %s', 
		$user->email, 
		(new DateTime)->format('Y-m-d H:i:s'));
	Log::info($log);
});

Event::listen('auth.logout', function()
{

});

Event::listen('post.indexing', function()
{
	IndexToolController::indexPostAction();
});