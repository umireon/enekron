<?php

use Phpmig\Migration\Migration;
use \Doctrine\DBAL\Schema\Schema;

class CreateTacks extends Migration
{
	public function getSchema() {
		$schema = new Schema();
		$tacks = $schema->createTable("tacks");

		$tacks->addColumn('id', 'integer', array('autoincrement' => true));
		$tacks->addColumn('title', 'string', array('length' => 255));
		$tacks->addColumn('content', 'text');
		$tacks->addColumn('year', 'integer', array(
			'customSchemaOptions' => array(
				'check' => 'CHECK(year >= 0 AND year <= 9999)',
			)
		));
		$tacks->addColumn('month', 'integer', array(
			'customSchemaOptions' => array(
				'check' => 'CHECK(month >= 1 AND month <= 12)',
			)
		));
		$tacks->addColumn('day', 'integer', array(
			'customSchemaOptions' => array(
				'check' => 'CHECK(day >= 1 AND day <= 31)',
			)
		));
		$tacks->addColumn('created_at', 'datetime');
		$tacks->addColumn('modified_at', 'datetime');

		$tacks->setPrimaryKey(array('id'));
		$tacks->addUniqueIndex(array('year', 'month', 'day', 'title'));

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
