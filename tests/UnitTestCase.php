<?php
abstract class UnitTestCase extends \PHPUnit_Framework_TestCase {

    /**
     * @var bool
     */
    private $_loaded = false;

    /**
     * Default fixture for each test
     */
    public function setUp() {
        parent::setUp();
        $this->_loaded = true;
    }

    /**
     * Check if the test case is setup properly
     * @throws \PHPUnit_Framework_IncompleteTestError;
     */
    public function __destruct() {
        if(!$this->_loaded) {
            throw new \PHPUnit_Framework_IncompleteTestError('Please run parent::setUp().');
        }
    }
}