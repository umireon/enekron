<?php defined('SYSPATH') or die('No direct script access.');

require_once('markdown.php');

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

	public function newer()
	{
		$this->order_by('modified_at', 'DESC');
		return $this;
	}

	public function find_newest_id()
	{
		return $this->select('id')->newer()->find()->id;
	}

	public function in_page(Pagination $pagination)
	{
		$this->offset($pagination->offset)
		     ->limit($pagination->items_per_page);
		return $this;
	}

	public function save(Validation $validation = NULL)
	{
		if ( ! $this->pk())
		{
			$this->created_at = Date::formatted_time();
		}

		if ( ! isset($this->_changed['modified_at']))
		{
			$this->modified_at = Date::formatted_time();
		}

		return parent::save($validation);
	}

} // End Tack
