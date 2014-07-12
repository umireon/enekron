<?php

/**
 * @package    Model
 * @category   Test
 * @author     Kaito Udagawa
 * @copyright  Copyright (c) 2014 Kaito Udagawa
 * @license    http://opensource.org/licenses/MIT
 */
class Model_TackTest extends PHPUnit_Framework_TestCase
{
	public function testCreate()
	{
		$tack = new Model_Tack;
		$tack->title = "title";
		$tack->content = "content";
		$tack->created_by = "0";
		$tack->save();
	}
} // End TackTest
