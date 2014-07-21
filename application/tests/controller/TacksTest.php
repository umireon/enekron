<?php

/**
 * @package    Controller
 * @category   Test
 * @author     Kaito Udagawa
 * @copyright  Copyright (c) 2014 Kaito Udagawa
 * @license    http://opensource.org/licenses/MIT
 */
class Controller_TackTest extends PHPUnit_Framework_TestCase
{
	public function testRouteIndex()
	{
		$request = Request::factory('tacks');
		$this->assertEquals('tacks', $request->controller());
		$this->assertEquals('index', $request->action());
	}

	public function testRouteShow()
	{
		$request = Request::factory('tacks/2014/07/21/title');
		$this->assertEquals('tacks', $request->controller());
		$this->assertEquals('show', $request->action());
		$this->assertEquals(array(
			'year'  => '2014',
			'month' => '07',
			'day'   => '21',
			'name'  => 'title'
		), $request->param());
	}

	public function testRouteAdd()
	{
		$request = Request::factory('tacks/add/2014/07/21/title');
		$this->assertEquals('tacks', $request->controller());
		$this->assertEquals('add', $request->action());
		$this->assertEquals(array(
			'year'  => '2014',
			'month' => '07',
			'day'   => '21',
			'name'  => 'title'
		), $request->param());
	}

	public function testEdit()
	{
		$request = Request::factory('tacks/edit/2014/07/21/title');
		$this->assertEquals('tacks', $request->controller());
		$this->assertEquals('edit', $request->action());
		$this->assertEquals(array(
			'year'  => '2014',
			'month' => '07',
			'day'   => '21',
			'name'  => 'title'
		), $request->param());
	}

	public function testDelete()
	{
		$request = Request::factory('tacks/delete/2014/07/21/title');
		$this->assertEquals('tacks', $request->controller());
		$this->assertEquals('delete', $request->action());
		$this->assertEquals(array(
			'year'  => '2014',
			'month' => '07',
			'day'   => '21',
			'name'  => 'title'
		), $request->param());
	}
} // End TackTest
