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
		$req = new Request('tacks');
		$res = $req->execute();
		$this->assertContains('title1', $res->body());
	}

	public function testShow()
	{
		$req = new Request('tacks/2000/01/01/title1');
		$res = $req->execute();
		$this->assertContains('title1', $res->body());
	}

	public function testAddGet()
	{
		$req = new Request('tacks/add');
		$res = $req->execute();
		$this->assertContains('tacks/add', $res->body());
	}

	public function testAddPost()
	{
		$req = new Request('tacks/add');
		$req->method('POST');
		$req->post(array(
			'title' => 'title',
			'content' => 'content',
		));
		$res = $req->execute();
	}

	public function testEditGet()
	{
		$req = new Request('tacks/edit/2000/01/01/title1');
		$res = $req->execute();
		$this->assertContains('title1', $res->body());
	}

	public function testEditPost()
	{
		$req = new Request('tacks/edit/2000/01/01/title1');
		$req->method('POST');
		$req->post(array(
			'title' => 'title',
			'content' => 'content',
		));
		$res = $req->execute();

		$model = new Model_Tack;
		$tack = $model->find_by_date_and_title(2000, 1, 1, 'title');
		$this->assertTrue($tack->loaded());
		$this->assertSame($tack->title, 'title');
	}

	public function testDeleteGet()
	{
		$req = new Request('tacks/delete/2000/01/01/title1');
		$res = $req->execute();
		$this->assertContains('title1', $res->body());
	}

	public function testDeletePost()
	{
		$req = new Request('tacks/delete/2000/01/01/title1');
		$req->method('POST');
		$res = $req->execute();

		$model = new Model_Tack;
		$tack = $model->find_by_date_and_title(2000, 1, 1, 'title');
		$this->assertFalse($tack->loaded());
	}
} // End TackTest
