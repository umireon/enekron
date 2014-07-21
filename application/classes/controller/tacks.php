<?php

class Controller_Tacks extends Controller {

	public function action_index()
	{
		$tacks = ORM::factory('tack')->find_all();
		$this->response->body(var_export($tacks->as_array(), TRUE));
	}

	public function action_show()
	{
	}

	public function action_add()
	{
	}

	public function action_edit()
	{
	}

	public function action_delete()
	{
	}

} // End Tacks
