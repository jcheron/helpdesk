<?php

class SeleniumTest extends \AjaxUnitTest{
	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();
		self::get("Selenium/index");
	}
	public function testDefault(){
		$this->assertPageContainsText('Hello Selenium');
		$this->assertTrue($this->elementExists("#text"));
		$this->assertTrue($this->elementExists("#frm"));
	}
	public function testValidation(){
		$this->getElementById("text")->sendKeys("okay");
		$this->getElementById("text")->sendKeys("\xEE\x80\x87");
		SeleniumTest::$webDriver->manage()->timeouts()->implicitlyWait(5);
		$this->assertEquals("okay",$this->getElementById("result")->getText());
	}
}