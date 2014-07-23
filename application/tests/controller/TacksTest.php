<?php
require_once 'application/tests/DBTestCase.php';

/**
 * @package    Controller
 * @category   Test
 * @author     Kaito Udagawa
 * @copyright  Copyright (c) 2014 Kaito Udagawa
 * @license    http://opensource.org/licenses/MIT
 */
class Controller_TacksTest extends PHPUnit_Framework_TestCase
{
	public static $model = 'Model_Tack';
	public static $factory = 'Factory';

	public function testIndex()
	{
		$model = $this->getMock(self::$model);
		$model->expects($this->once())
		      ->method('find_all')
		      ->will($this->returnSelf());

		$factory = $this->getMock(self::$factory);
		$factory->expects($this->once())
		        ->method('model')
		        ->with($this->identicalTo('tack'))
		        ->will($this->returnValue($model));
		$factory->expects($this->once())
		        ->method('view')
		        ->with($this->identicalTo('tacks/index'),
		               $this->identicalTo(array('tacks' => $model)))
		        ->will($this->returnValue('tacks/index'));

		$req = new Request('');
		$res = new Response();
		$ctrl = new Controller_Tacks($req, $res);
		$ctrl->set_factory($factory);

		// code
		$ctrl->action_index();
		// end code

		$this->assertContains('tacks/index', $res->body());
	}

	public function testShow()
	{
		$model = $this->getMock(self::$model);
		$model->expects($this->once())
		      ->method('find_by_date_and_title')
		      ->with($this->equalTo('2000'),
		      	     $this->equalTo('01'),
		      	     $this->equalTo('01'),
		      	     $this->equalTo('title'))
		      ->will($this->returnSelf());

		$factory = $this->getMock(self::$factory);
		$factory->expects($this->once())
		        ->method('model')
		        ->with($this->identicalTo('tack'))
		        ->will($this->returnValue($model));
		$factory->expects($this->once())
		        ->method('view')
		        ->with($this->identicalTo('tacks/show'),
		               $this->identicalTo(array('tack' => $model)))
		        ->will($this->returnValue('tacks/show'));

		$req = new Request('tacks/2000/01/01/title', NULL, array(
			'injected' => new Route('<controller>/<year>/<month>/<day>/<title>'),
		));
		$res = new Response();
		$ctrl = new Controller_Tacks($req, $res);
		$ctrl->set_factory($factory);

		// code
		$ctrl->action_show();
		// end code

		$this->assertContains('tacks/show', $res->body());
	}

	public function testAddGet()
	{
		$factory = $this->getMock(self::$factory);
		$factory->expects($this->once())
		        ->method('view')
		        ->with($this->identicalTo('tacks/add'))
		        ->will($this->returnValue('tacks/add'));

		$req = new Request('');
		$res = new Response();
		$ctrl = new Controller_Tacks($req, $res);
		$ctrl->set_factory($factory);

		// code
		$ctrl->action_add();
		// end code
	}

	public function testAddPost()
	{
		$model = $this->getMock(self::$model, array('create'));
		$model->expects($this->once())
		      ->method('create')
		      ->with()
		      ->will($this->returnSelf());

		$factory = $this->getMock(self::$factory);
		$factory->expects($this->once())
		        ->method('model')
		        ->with($this->identicalTo('tack'))
		        ->will($this->returnValue($model));

		$req = new Request('');
		$req->method('POST');
		$req->post(array(
			'title' => 'title',
			'content' => 'content',
		));
		$res = new Response();
		$ctrl = new Controller_Tacks($req, $res);
		$ctrl->set_factory($factory);

		// code
		$ctrl->action_add();
		// end code

		$this->assertSame('title', $model->title);
		$this->assertSame('content', $model->content);
	}

	public function testEditGet()
	{
		$model = $this->getMock(self::$model);
		$model->expects($this->once())
		      ->method('find_by_date_and_title')
		      ->with($this->equalTo('2000'),
		      	     $this->equalTo('01'),
		      	     $this->equalTo('01'),
		      	     $this->equalTo('title'))
		      ->will($this->returnSelf());

		$factory = $this->getMock(self::$factory);
		$factory->expects($this->once())
		        ->method('model')
		        ->with($this->identicalTo('tack'))
		        ->will($this->returnValue($model));
		$factory->expects($this->once())
		        ->method('view')
		        ->with($this->identicalTo('tacks/edit'),
		               $this->identicalTo(array('tack' => $model)))
		        ->will($this->returnValue('tacks/edit'));

		$req = new Request('tacks/2000/01/01/title', NULL, array(
			'injected' => new Route('<controller>/<year>/<month>/<day>/<title>'),
		));
		$res = new Response();
		$ctrl = new Controller_Tacks($req, $res);
		$ctrl->set_factory($factory);

		// code
		$ctrl->action_edit();
		// end code

		$this->assertContains('tacks/edit', $res->body());
	}

	public function testEditPost()
	{
		$model = $this->getMock(self::$model, array('find_by_date_and_title', 'update'));
		$model->expects($this->once())
		      ->method('find_by_date_and_title')
		      ->with($this->equalTo('2000'),
		      	     $this->equalTo('01'),
		      	     $this->equalTo('01'),
		      	     $this->equalTo('title'))
		      ->will($this->returnSelf());
		$model->expects($this->once())
		      ->method('update')
		      ->with()
		      ->will($this->returnSelf());

		$factory = $this->getMock(self::$factory);
		$factory->expects($this->once())
		        ->method('model')
		        ->with($this->identicalTo('tack'))
		        ->will($this->returnValue($model));

		$req = new Request('tacks/2000/01/01/title', NULL, array(
			'injected' => new Route('<controller>/<year>/<month>/<day>/<title>'),
		));
		$req->method('POST');
		$req->post(array(
			'title' => 'title',
			'content' => 'content',
		));
		$res = new Response();
		$ctrl = new Controller_Tacks($req, $res);
		$ctrl->set_factory($factory);

		// code
		$ctrl->action_edit();
		// end code

		$this->assertSame('title', $model->title);
		$this->assertSame('content', $model->content);
	}

	public function testDeleteGet()
	{
		$model = $this->getMock(self::$model);
		$model->expects($this->once())
		      ->method('find_by_date_and_title')
		      ->with($this->equalTo('2000'),
		      	     $this->equalTo('01'),
		      	     $this->equalTo('01'),
		      	     $this->equalTo('title'))
		      ->will($this->returnSelf());

		$factory = $this->getMock(self::$factory);
		$factory->expects($this->once())
		        ->method('model')
		        ->with($this->identicalTo('tack'))
		        ->will($this->returnValue($model));
		$factory->expects($this->once())
		        ->method('view')
		        ->with($this->identicalTo('tacks/delete'),
		               $this->identicalTo(array('tack' => $model)))
		        ->will($this->returnValue('tacks/delete'));

		$req = new Request('tacks/2000/01/01/title', NULL, array(
			'injected' => new Route('<controller>/<year>/<month>/<day>/<title>'),
		));
		$res = new Response();
		$ctrl = new Controller_Tacks($req, $res);
		$ctrl->set_factory($factory);

		// code
		$ctrl->action_delete();
		// end code

		$this->assertContains('tacks/delete', $res->body());
	}

	public function testDeletePost()
	{
		$model = $this->getMock(self::$model, array('find_by_date_and_title', 'delete'));
		$model->expects($this->once())
		      ->method('find_by_date_and_title')
		      ->with($this->equalTo('2000'),
		      	     $this->equalTo('01'),
		      	     $this->equalTo('01'),
		      	     $this->equalTo('title'))
		      ->will($this->returnSelf());
		$model->expects($this->once())
		      ->method('delete')
		      ->with()
		      ->will($this->returnSelf());

		$factory = $this->getMock(self::$factory);
		$factory->expects($this->once())
		        ->method('model')
		        ->with($this->identicalTo('tack'))
		        ->will($this->returnValue($model));

		$req = new Request('tacks/2000/01/01/title', NULL, array(
			'injected' => new Route('<controller>/<year>/<month>/<day>/<title>'),
		));
		$req->method('POST');
		$res = new Response();
		$ctrl = new Controller_Tacks($req, $res);
		$ctrl->set_factory($factory);

		// code
		$ctrl->action_delete();
		// end code
	}
} // End TackTest
