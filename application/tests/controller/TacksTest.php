<?php
require_once 'application/tests/DBTestCase.php';

/**
 * @package    Controller
 * @category   Test
 * @author     Kaito Udagawa
 * @copyright  Copyright (c) 2014 Kaito Udagawa
 * @license    http://opensource.org/licenses/MIT
 */
class Controller_TackTest extends DBTestCase
{
	protected $yaml = 'application/tests/fixture/tacks.yml';

	public function testRouteIndex()
	{
		$response = Request::factory('tacks')->execute();
		$this->assertContains('title1', $response->body());
	}
} // End TackTest
