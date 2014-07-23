<?php

/**
 * @package    Route
 * @category   Test
 * @author     Kaito Udagawa
 * @copyright  Copyright (c) 2014 Kaito Udagawa
 * @license    http://opensource.org/licenses/MIT
 */
class Route_TacksTest extends PHPUnit_Framework_TestCase
{
	protected $param = array(
		'year'  => '2014',
		'month' => '07',
		'day'   => '21',
		'title'  => 'title',
	);

	protected $path = '2014/07/21/title';

	public function testIndex()
	{
		$request = Request::factory('tacks');
		$this->assertEquals('tacks', $request->controller());
		$this->assertEquals('index', $request->action());
	}

	public function testShow()
	{
		$request = Request::factory("tacks/{$this->path}");
		$this->assertEquals('tacks', $request->controller());
		$this->assertEquals('show', $request->action());
		$this->assertEquals($this->param, $request->param());
	}

	public function testAdd()
	{
		$request = Request::factory("tacks/add/{$this->path}");
		$this->assertEquals('tacks', $request->controller());
		$this->assertEquals('add', $request->action());
		$this->assertEquals($this->param, $request->param());
	}

	public function testEdit()
	{
		$request = Request::factory("tacks/edit/{$this->path}");
		$this->assertEquals('tacks', $request->controller());
		$this->assertEquals('edit', $request->action());
		$this->assertEquals($this->param, $request->param());
	}

	public function testDelete()
	{
		$request = Request::factory("tacks/delete/{$this->path}");
		$this->assertEquals('tacks', $request->controller());
		$this->assertEquals('delete', $request->action());
		$this->assertEquals($this->param, $request->param());
	}
} // End TackTest
