<?php

/**
 * @package    Schema
 * @category   Test
 * @author     Kaito Udagawa
 * @copyright  Copyright (c) 2014 Kaito Udagawa
 * @license    http://opensource.org/licenses/MIT
 */
class Schema_TackTest extends PHPUnit_Extensions_Database_TestCase
{
	static private $pdo = NULL;
	private $conn;

	final public function getConnection()
	{
		if ($this->conn === NULL) {
			if (self::$pdo == NULL) {
				self::$pdo = new PDO(getenv('DATABASE_DSN'));
			}
			$this->conn = $this->createDefaultDBConnection(self::$pdo);
		}
		return $this->conn;
	}

	final public function getDataSet() {
		return new PHPUnit_Extensions_Database_DataSet_YamlDataSet(
			dirname(__FILE__).'/fixture-tacks.yml'
		);
	}

	public function testCreate()
	{
		new Model_Tack(1);
	}
} // End TackTest
