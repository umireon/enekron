<?php

/**
 * @package    Model
 * @author     Kaito Udagawa
 * @copyright  Copyright (c) 2014 Kaito Udagawa
 * @license    http://opensource.org/licenses/MIT
 */
class Model_Tack extends ORM {
	protected $_table_name = 'tacks';
	protected $_table_columns = array(
		'id' => NULL,
		'title' => NULL,
		'content' => NULL,
		'created_by' => NULL,
		'created_at' => NULL,
		'modified_at' => NULL,
	);

	public function create(Validation $validation = NULL)
	{
		$this->created_at = Date::formatted_time();
		$this->modified_at = $this->created_at;

		return parent::create($validation);
	}

	public function update(Validation $validation = NULL)
	{
		if ( ! isset($this->_changed['modified_at']))
		{
			$this->modified_at = Date::formatted_time();
		}

		return parent::update($validation);
	}

} // End Tack
