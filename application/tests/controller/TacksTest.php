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
	public function testIndex()
	{
		Request::factory('tacks')->execute();
	}
} // End TackTest
