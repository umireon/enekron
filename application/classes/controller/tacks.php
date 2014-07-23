<?php

class Controller_Tacks extends Controller {
	private $factory;

	public function before()
	{
		parent::before();
		if (empty($this->factory)) {
			$this->factory = new Factory;
		}
	}

	final public function set_factory(Factory $factory)
	{
		$this->factory = $factory;
	}

	public function action_index()
	{
		$tacks = $this->factory->model('tack')->find_all();
		$view = $this->factory->view('tacks/index', array('tacks' => $tacks));
		$this->response->body($view);
	}

	public function action_show()
	{
		$req = $this->request;
		$year = $req->param('year');
		$month = $req->param('month');
		$day = $req->param('day');
		$title = $req->param('title');

		$model = $this->factory->model('tack');
		$tack = $model->find_by_date_and_title($year, $month, $day, $title);
		$view = $this->factory->view('tacks/show', array('tack' => $tack));
		$this->response->body($view);
	}

	public function action_add()
	{
		$req = $this->request;

		if ($req->method() === 'POST') {
			$model = $this->factory->model('tack');
			$model->title = $req->post('title');
			$model->content = $req->post('content');
			$model->create();
		} else {
			$view = $this->factory->view('tacks/add');
			$this->response->body($view);
		}
	}

	public function action_edit()
	{
		$req = $this->request;

		$year = $req->param('year');
		$month = $req->param('month');
		$day = $req->param('day');
		$title = $req->param('title');

		$model = $this->factory->model('tack');
		$tack = $model->find_by_date_and_title($year, $month, $day, $title);

		if ($req->method() === 'POST') {
			$tack->title = $req->post('title');
			$tack->content = $req->post('content');
			$tack->update();
		} else {
			$view = $this->factory->view('tacks/edit', array('tack' => $tack));
			$this->response->body($view);
		}
	}

	public function action_delete()
	{
		$req = $this->request;

		$year = $req->param('year');
		$month = $req->param('month');
		$day = $req->param('day');
		$title = $req->param('title');

		$model = $this->factory->model('tack');
		$tack = $model->find_by_date_and_title($year, $month, $day, $title);

		if ($req->method() === 'POST') {
			$tack->delete();
		} else {
			$view = $this->factory->view('tacks/delete', array('tack' => $tack));
			$this->response->body($view);
		}
	}

} // End Tacks
