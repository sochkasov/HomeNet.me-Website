<?php

/**
 * Test class for HomeNet_Model_Datapoint_Service.
 * Generated by PHPUnit on 2011-11-21 at 16:34:05.
 */
class HomeNet_Model_Datapoint_ServiceTest extends PHPUnit_Framework_TestCase {

    /**
     * @var HomeNet_Model_Datapoint_Service
     */
    protected $service;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->service = new HomeNet_Model_Datapoint_Service;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

     public function testGetMapper() {
         $this->service->setType('Int');
       $this->assertInstanceOf('HomeNet_Model_Datapoint_MapperInterface', $this->service->getMapper());
    }

    public function testSetMapper() {
        $this->service->setType('Int');
        $mapper = new HomeNet_Model_Datapoint_MapperDbTable('int');
         $this->service->setMapper($mapper);
        
        $this->assertInstanceOf('HomeNet_Model_Datapoint_MapperInterface', $this->service->getMapper());
        $this->assertEquals($mapper, $this->service->getMapper());
    }

    public function testSetType() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testGetNewestDatapointBySubdevice() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testGetAveragesBySubdeviceTimespan() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testGetDatapointsBySubdeviceTimespan() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testAdd() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testCreate() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testUpdate() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testDelete() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

}