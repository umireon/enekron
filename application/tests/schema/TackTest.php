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

	private function getPDO()
	{
		if (self::$pdo === NULL) {
			$db = getenv('DB');
			$opts = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
			if ($db === FALSE) {
				$dsn = 'sqlite:application/default.sqlite3';
				self::$pdo = new PDO($dsn, NULL, NULL, $opts);
			} elseif ($db === 'sqlite') {
				$dbpath = getenv('DBPATH');
				$dsn = "sqlite:$dbpath";
				self::$pdo = new PDO($dsn, NULL, NULL, $opts);
			} else {
				$dbhost = getenv('DBHOST');
				$dbport = getenv('DBPORT');
				$dbname = getenv('DBNAME');
				$dbuser = getenv('DBUSER');
				$dbpass = getenv('DBPASS');
				$dsn = "$db:host=$dbhost;dbname=$dbname";
				self::$pdo = new PDO($dsn, $dbuser, $dbpass, $opts);
				self::$pdo->exec("SET NAMES 'utf8'");
			}
		}
		return self::$pdo;
	}

	final public function getConnection()
	{
		if ($this->conn === NULL) {
			$pdo = $this->getPDO();
			$this->conn = $this->createDefaultDBConnection($pdo);
		}
		return $this->conn;
	}

	final public function getDataSet() {
		return new PHPUnit_Extensions_Database_DataSet_YamlDataSet(
			dirname(__FILE__).'/fixture-tacks.yml'
		);
	}

	public function setUp()
	{
		parent::setUp();
		$driver = self::$pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
		if ($driver === 'pgsql') {
			self::$pdo->query("SELECT setval('tacks_id_seq', 1000)");
		}
	}

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
