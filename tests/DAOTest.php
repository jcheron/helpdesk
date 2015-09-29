<?php

use micro\orm\DAO;
class DAOTest extends \PHPUnit_Framework_TestCase{

	/* (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp() {
		global $config;
		Logger::init();

		extract($config["database"]);
		$db=$config["database"];
		DAO::connect($db["dbName"],@$db["serverName"],@$db["port"],@$db["user"],@$db["password"]);
	}

	private function loadOne($className){
		$objects=DAO::getAll($className);
		$this->assertArrayHasKey(0, $objects);
		$this->assertNotNull($objects[0]);
		$o=DAO::getOne($className, $objects[0]->getId());
		$this->assertNotNull($o);
		$this->assertEquals($objects[0]->getId(), $o->getId());
	}
	public function testLoadModels(){
		$models=["Ticket","Faq","Message","Statut","User","Categorie"];
		foreach ($models as $model){
			$this->loadOne($model);
		}
	}
}