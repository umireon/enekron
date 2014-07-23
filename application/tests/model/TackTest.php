<?php
require_once 'application/tests/DBTestCase.php';

/**
 * @package    Model
 * @category   Test
 * @author     Kaito Udagawa
 * @copyright  Copyright (c) 2014 Kaito Udagawa
 * @license    http://opensource.org/licenses/MIT
 */
class Model_TackTest extends DBTestCase
{
	protected $yaml = 'application/tests/fixture/tacks.yml';

	public function testFindByDateAndTitleUsingInteger()
	{
		$model = new Model_Tack();
		$tack = $model->find_by_date_and_title(2000, 1, 1, 'title1');
		$this->assertTrue($tack->loaded());
	}

	public function testFindByDateAndTitleUsingString()
	{
		$model = new Model_Tack();
		$tack = $model->find_by_date_and_title('2000', '1', '1', 'title1');
		$this->assertTrue($tack->loaded());
	}

	public function testFindByDateAndTitleUsing0Padding()
	{
		$model = new Model_Tack();
		$tack = $model->find_by_date_and_title('2000', '01', '01', 'title1');
		$this->assertTrue($tack->loaded());
	}

	public function testDateIsCreatedOnCreate()
	{
		$tack = new Model_Tack();
		$tack->title = 'title';
		$tack->content = 'content';
		$tack->create();

		$created_at = new DateTime($tack->created_at);
		$year = (int) $created_at->format('Y');
		$month = (int) $created_at->format('n');
		$day = (int) $created_at->format('j');
		$this->assertSame($year, $tack->year);
		$this->assertSame($month, $tack->month);
		$this->assertSame($day, $tack->day);
	}
} // End TackTest
