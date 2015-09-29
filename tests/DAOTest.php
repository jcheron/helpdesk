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

	public function testLoadOne(){
		$ticket=DAO::getOne("Ticket", 1);
		$this->assertNotNull($ticket);
	}
}