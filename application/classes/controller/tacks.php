<?php

class Controller_Tacks extends Controller {
	protected function newModelTack($id = NULL)
	{
		return new Model_Tack($id);
	}

	public function action_index()
	{
		$tacks = $this->newModelTack()->find_all();
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
