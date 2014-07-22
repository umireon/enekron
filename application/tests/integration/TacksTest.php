<?php
require_once 'application/tests/DBTestCase.php';

/**
 * @package    Integration
 * @category   Test
 * @author     Kaito Udagawa
 * @copyright  Copyright (c) 2014 Kaito Udagawa
 * @license    http://opensource.org/licenses/MIT
 */
class Integration_TacksTest extends DBTestCase
{
	protected $yaml = 'application/tests/fixture/tacks.yml';

	public function testIndex()
	{
		$req = Request::factory('tacks');
		$res = $req->execute();
		$this->assertContains('title1', $res->body());
	}

	public function testShow()
	{
		$req = Request::factory('tacks/2000/01/01/title1');
		$res = $req->execute();
		$this->assertContains('title1', $res->body());
	}
} // End TackTest
