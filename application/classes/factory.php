<?php

/**
 * @author     Kaito Udagawa
 * @copyright  Copyright (c) 2014 Kaito Udagawa
 * @license    http://opensource.org/licenses/MIT
 */
class Factory {
	public function model($model, $id = NULL)
	{
		return ORM::factory($model, $id);
	}

	public function view($file, $data = NULL)
	{
		return ORM::factory($model, $data);
	}
} // End Factory

