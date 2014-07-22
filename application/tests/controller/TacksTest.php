<?php
require_once 'application/tests/DBTestCase.php';

/**
 * @package    Controller
 * @category   Test
 * @author     Kaito Udagawa
 * @copyright  Copyright (c) 2014 Kaito Udagawa
 * @license    http://opensource.org/licenses/MIT
 */
class Controller_TacksTest extends DBTestCase
{
	protected $yaml = 'application/tests/fixture/tacks.yml';

	public function testIndex()
	{
		$model = $this->getMock('Model_Tack');
		$model->expects($this->once())
		      ->method('find_all')
		      ->will($this->returnSelf());

		$factory = $this->getMock('Factory');
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
		$model = $this->getMock('Model_Tack');
		$model->expects($this->once())
		      ->method('find_by_date_and_title')
		      ->with($this->equalTo('2000'),
		      	     $this->equalTo('01'),
		      	     $this->equalTo('01'),
		      	     $this->equalTo('title'))
		      ->will($this->returnSelf());

		$factory = $this->getMock('Factory');
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
} // End TackTest
