<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Permission keys table
	|--------------------------------------------------------------------------
	|
	| all of key for use with sentry2
	| example:
	| if (Sentry::getUser()->hasAccess('dashboard')) {
	|	// allow this place...
	| }
	| reference : https://cartalyst.com/manual/sentry/users/helpers
	*/

	// default permission

	'keys' => array(
		'dashboard'		=> 1,
		'content'		=> 1,
		
		'user.add'		=> 1,
		'user.update'	=> 1,
		'user.delete'	=> 1,
		'user.show'		=> 1,
		'user.ban'		=> 1,
		'user.suspend'	=> 1,

		'member'		=> 1,
		'subscriber'	=> 1,
		'import_export'	=> 1,
		'language'		=> 1,
		'email_template'=> 1,
		'profile'		=> 1
	)
);