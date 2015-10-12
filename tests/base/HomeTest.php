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
	public function testAjax(){
		$this->waitFor(5);
		$btAjax=$this->getElementBySelector(".btAjax");
		$btAjax->click();
		$this->waitForElementPresent(function(){ return $this->elementExists("#btClose");});
		$this->assertNotNull($this->getElementById("btClose"));
	}
}