<?php

class Language extends Eloquent  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'languages';
	protected $guarded = array('id');

}
