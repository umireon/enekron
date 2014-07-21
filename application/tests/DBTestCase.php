<?php

/**
 * @category   Test
 * @author     Kaito Udagawa
 * @copyright  Copyright (c) 2014 Kaito Udagawa
 * @license    http://opensource.org/licenses/MIT
 */
abstract class DBTestCase extends PHPUnit_Extensions_Database_TestCase
{
	protected $yaml;

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
		return new PHPUnit_Extensions_Database_DataSet_YamlDataSet($this->yaml);
	}

	public function setUp()
	{
		parent::setUp();
		$driver = self::$pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
	}
} // End DBTestCase
