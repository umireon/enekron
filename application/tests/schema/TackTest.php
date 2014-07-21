<?php
require_once 'application/tests/DBTestCase.php';

/**
 * @package    Schema
 * @category   Test
 * @author     Kaito Udagawa
 * @copyright  Copyright (c) 2014 Kaito Udagawa
 * @license    http://opensource.org/licenses/MIT
 */
class Schema_TackTest extends DBTestCase
{
	protected $yaml = 'application/tests/fixture/tacks.yml';

	public function testFindById()
	{
		$tack = new Model_Tack(1);
		$this->assertTrue($tack->loaded());
		$this->assertEquals('title1', $tack->title);
	}

	public function testNonexistent()
	{
		$tack = new Model_Tack(1000);
		$this->assertFalse($tack->loaded());
		$this->assertNull($tack->pk());
	}

	public function testCreate()
	{
		$tack = new Model_Tack();
		$this->assertFalse($tack->loaded());
		$tack->title = 'newTitle';
		$tack->content = 'newContent';
		$tack->created_by = 1;
		$tack->save();
		$this->assertTrue($tack->loaded());
		$this->assertGreaterThan(1, $tack->pk());
		$this->assertNotNull(1, $tack->created_at);
		$this->assertNotNull(1, $tack->modified_at);

		$tack2 = new Model_Tack($tack->pk());
		$this->assertEquals($tack->pk(), $tack2->pk());
		$this->assertEquals('newTitle', $tack2->title);
	}

	public function testUpdate()
	{
		$tack = new Model_Tack(1);
		$tack->title = 'newTitle';
		$tack->save();
		$this->assertEquals(1, $tack->pk());
		$this->assertTrue($tack->modified_at !== $tack->created_at);

		$tack2 = new Model_Tack(1);
		$this->assertEquals('newTitle', $tack2->title);
	}

	public function testDelete()
	{
		$tack = new Model_Tack(1);
		$tack->delete();
		$this->assertNull($tack->pk());

		$tack2 = new Model_Tack(1);
		$this->assertFalse($tack->loaded());
	}
} // End TackTest
