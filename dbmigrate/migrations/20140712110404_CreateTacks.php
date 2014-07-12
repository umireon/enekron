<?php

use Phpmig\Migration\Migration;
use \Doctrine\DBAL\Schema\Schema;

class CreateTacks extends Migration
{
	public function getSchema() {
		$schema = new Schema();
		$tacks = $schema->createTable("tacks");

		$tacks->addColumn('id', 'integer', array('autoincrement' => true));
		$tacks->addColumn('title', 'text');
		$tacks->addColumn('content', 'text');
		$tacks->addColumn('created_by', 'string');
		$tacks->addColumn('created_at', 'datetime');
		$tacks->addColumn('modified_at', 'datetime');

		$tacks->setPrimaryKey(array('id'));

		return $schema;
	}

	/**
	 * Do the migration
	 */
	public function up()
	{
		$container = $this->getContainer();
		$conn = $container['db'];
		$platform = $conn->getDatabasePlatform();
		$schema = $this->getSchema();
		$queries = $schema->toSql($platform);
		foreach ($queries as $query) {
			$conn->query($query);
		}
	}

	/**
	 * Undo the migration
	 */
	public function down()
	{
		$container = $this->getContainer();
		$conn = $container['db'];
		$platform = $conn->getDatabasePlatform();
		$schema = $this->getSchema();
		$queries = $schema->toDropSql($platform);
		foreach ($queries as $query) {
			$conn->query($query);
		}
	}
}
