<?php

class HomeTest extends AjaxUnitTest {
	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();
		self::get("DefaultC/index");
	}
	public function testDefault(){
		SeleniumTest::$webDriver->manage()->timeouts()->implicitlyWait(5);
		$this->assertPageContainsText('HelpDesk');
		$this->assertTrue($this->elementExists("#response"));
	}
}