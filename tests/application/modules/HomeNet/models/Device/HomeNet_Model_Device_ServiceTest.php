<?php

/**
 * Test class for HomeNet_Model_Device_Service.
 * Generated by PHPUnit on 2011-11-21 at 16:34:19.
 */
class HomeNet_Model_Device_ServiceTest extends PHPUnit_Framework_TestCase {

    /**
     * @var HomeNet_Model_Device_Service
     */
    protected $service;
    protected $homenetInstaller;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->service = new HomeNet_Model_Device_Service;
        $this->homenetInstaller = new HomeNet_Installer();
        $this->homenetInstaller->installTest(array('house', 'room', 'node', 'device'));
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    private function createValidObject() {

        $object = new HomeNet_Model_Device();
        $object->node = 1;
        $object->model = $this->homenetInstaller->deviceModel->test->id;
        $object->position = 3;
        $object->components = 4;
        $object->settings = array('key' => 'value');

        $result = $this->service->create($object);

        $this->assertInstanceOf('HomeNet_Model_Device_Interface', $result);
        return $result;
    }

    private function validateResult($result) {
        $this->assertNotNull($result->id);
        $this->assertEquals(1, $result->node);
        $this->assertEquals($this->homenetInstaller->deviceModel->test->id, $result->model);
        $this->assertEquals(3, $result->position);
        $this->assertEquals(4, $result->components);
        $this->assertTrue(is_array($result->settings));
        $this->assertEquals('value', $result->settings['key']);
    }

//$this->service->getMapper()///////////////////////////////////////////////////
    public function testGetMapper() {
        $this->assertInstanceOf('HomeNet_Model_Device_MapperInterface', $this->service->getMapper());
    }

//$this->service->setMapper($mapper)////////////////////////////////////////////
    public function testSetMapper() {
        $mapper = new HomeNet_Model_Device_MapperDbTable();
        $this->service->setMapper($mapper);

        $this->assertInstanceOf('HomeNet_Model_Device_MapperInterface', $this->service->getMapper());
        $this->assertEquals($mapper, $this->service->getMapper());
    }

//$this->service->getObjectById($id)////////////////////////////////////////////
    public function testGetObjectById_valid() {
        $object = $this->createValidObject();

        $result = $this->service->getObjectById($object->id);

        $this->validateResult($result);
    }

    public function testGetObjectById_invalid() {
        $this->setExpectedException('NotFoundException');
        $this->service->getObjectById(1000);
    }

    public function testGetObjectById_null() {
        $this->setExpectedException('InvalidArgumentException');
        $this->service->getObjectById(null);
    }

//$this->service->getObjectByNodePosition($node, $position)/////////////////////
    public function testGetObjectByNodePosition_valid() {
        $object = $this->createValidObject();
        $result = $this->service->getObjectByNodePosition($object->node, $object->position);
        $this->validateResult($result);
    }

    public function testGetObjectByNodePosition_invalidNode() {
        $this->setExpectedException('NotFoundException');
        $this->service->getObjectByNodePosition(1000, 1);
    }

    public function testGetObjectByNodePosition_invalidPosition() {
        $this->setExpectedException('NotFoundException');
        $this->service->getObjectByNodePosition($this->homenetInstaller->node->test->id, 1000);
    }

    public function testGetObjectByNodePosition_nullNode() {
        $this->setExpectedException('InvalidArgumentException');
        $this->service->getObjectByNodePosition(null, 1);
    }

    public function testGetObjectByNodePosition_nullPosition() {
        $this->setExpectedException('InvalidArgumentException');
        $this->service->getObjectByNodePosition($this->homenetInstaller->node->test->id, null);
    }

//$this->service->newObjectFromModel($id)///////////////////////////////////////
    public function testnewObjectFromModel_valid() {
        $result = $this->service->newObjectFromModel($this->homenetInstaller->deviceModel->test->id);
        $this->assertInstanceOf('HomeNet_Model_Device_Abstract', $result);
    }

    public function testnewObjectFromModel_invalid() {
        $this->setExpectedException('NotFoundException');
        $result = $this->service->newObjectFromModel(1000);
    }

    public function testnewObjectFromModel_null() {
        $this->setExpectedException('InvalidArgumentException');
        $result = $this->service->newObjectFromModel(null);
    }

//$this->service->getObjectsByNode($node)///////////////////////////////////////
    public function testGetObjectsByNode_valid() {
        $object = $this->createValidObject();

        $results = $this->service->getObjectsByNode($object->node);

        $this->validateResult(end($results));
    }

    public function testGetObjectsByNode_invalid() {
        $this->markTestIncomplete('Validation needs to be added');
        $this->setExpectedException('NotFoundException');
        $this->service->getObjectsByNode(1000);
    }

    public function testGetObjectsByNode_null() {
        $this->setExpectedException('InvalidArgumentException');
        $this->service->getObjectsByNode(null);
    }

//$this->service->getObjectByHouseNodeaddressPosition($node,$nodeAddress,$position)
    public function testGetObjectByHouseNodeaddressPosition_valid() {
        $object = $this->createValidObject();

        $result = $this->service->getObjectByHouseNodeaddressPosition($this->homenetInstaller->house->test->id, $this->homenetInstaller->node->test->address, $object->position);

        $this->validateResult($result);
    }

    public function testGetObjectByHouseNodeaddressPosition_invalid() {
        $this->setExpectedException('NotFoundException');
        $this->service->getObjectByHouseNodeaddressPosition(1000, 1, 1);
    }

    public function testGetObjectByHouseNodeaddressPosition_nullHouse() {
        $this->setExpectedException('InvalidArgumentException');
        $this->service->getObjectByHouseNodeaddressPosition(null, 1, 1);
    }

    public function testGetObjectByHouseNodeaddressPosition_nullAddress() {
        $this->setExpectedException('InvalidArgumentException');
        $this->service->getObjectByHouseNodeaddressPosition(1, null, 1);
    }

    public function testGetObjectByHouseNodeaddressPosition_nullPosition() {
        $this->setExpectedException('InvalidArgumentException');
        $this->service->getObjectByHouseNodeaddressPosition(1, 1, null);
    }

//$this->service->getObjectByIdWithNode($id)////////////////////////////////////    
    public function testGetObjectByIdWithNode_valid() {
        $object = $this->createValidObject();

        $result = $this->service->getObjectByIdWithNode($object->id);

        $this->validateResult($result);
    }

    public function testGetObjectByIdWithNode_invalid() {
        $this->setExpectedException('NotFoundException');
        $this->service->getObjectByIdWithNode(1000);
    }

    public function testGetObjectByIdWithNode_null() {
        $this->setExpectedException('InvalidArgumentException');
        $this->service->getObjectByIdWithNode(null);
    }

//$this->service->create($mixed)////////////////////////////////////////////////
    public function testCreate_validObject() {
        $result = $this->createValidObject();

        $this->assertNotNull($result->id);
        $this->validateResult($result);
    }

    public function testCreate_validArray() {
        $array = array(
            'node' => 1,
            'model' => $this->homenetInstaller->deviceModel->test->id,
            'position' => 3,
            'components' => 4,
            'settings' => array('key' => 'value'));

        $result = $this->service->create($array);
        $this->validateResult($result);
    }

    public function testCreate_invalidObject() {
        $this->setExpectedException('InvalidArgumentException');

        $badObject = new StdClass();
        $this->service->create($badObject);
    }

//$this->service->update($mixed)////////////////////////////////////////////////
    public function testUpdate_validObject() {
        //setup
        $object = $this->createValidObject();

        //update values
        $object->node = 2;
        $object->model = 3;
        $object->position = 4;
        $object->components = 5;
        $object->settings = array('key' => 'value2');

        $result = $this->service->update($object);

        $this->assertInstanceOf('HomeNet_Model_Device_Interface', $result);

        $this->assertNotNull($result->id);
        $this->assertEquals(2, $result->node);
        $this->assertEquals(3, $result->model);
        $this->assertEquals(4, $result->position);
        $this->assertEquals(5, $result->components);
        $this->assertTrue(is_array($result->settings));
        $this->assertEquals('value2', $result->settings['key']);
    }

    public function testUpdate_validArray() {
        //setup
        $object = $this->createValidObject();
        $array = $object->toArray();

        //update values
        $array['node'] = 2;
        $array['model'] = 3;
        $array['position'] = 4;
        $array['components'] = 5;
        $array['settings'] = array('key' => 'value2');

        $result = $this->service->update($array);

        $this->assertInstanceOf('HomeNet_Model_Device_Interface', $result);

        $this->assertNotNull($result->id);
        $this->assertEquals(2, $result->node);
        $this->assertEquals(3, $result->model);
        $this->assertEquals(4, $result->position);
        $this->assertEquals(5, $result->components);
        $this->assertTrue(is_array($result->settings));
        $this->assertEquals('value2', $result->settings['key']);
    }

    public function testUpdate_invalidObject() {
        $this->setExpectedException('InvalidArgumentException');

        $badObject = new StdClass();
        $create = $this->service->update($badObject);
    }

//$this->service->delete($mixed)////////////////////////////////////////////////
    public function testDelete_validObject() {
        //setup
        $object = $this->createValidObject();

        //test delete
        $id = $object->id;
        $this->service->delete($object);

        //verify that it was deleted
        $this->setExpectedException('NotFoundException');
        $result = $this->service->getObjectById($id);
    }

    public function testDelete_validArray() {
        //setup
        $object = $this->createValidObject();

        //test delete
        $id = $object->id;
        $this->service->delete($object->toArray());

        //verify that it was deleted
        $this->setExpectedException('NotFoundException');
        $result = $this->service->getObjectById($id);
    }

    public function testDelete_validId() {
        //setup
        $object = $this->createValidObject();

        //test delete
        $id = $object->id;
        $this->service->delete($object->id);

        //verify that it was deleted
        $this->setExpectedException('NotFoundException');
        $result = $this->service->getObjectById($id);
    }

    public function testDelete_invalidObject() {
        $this->setExpectedException('InvalidArgumentException');

        $badObject = new StdClass();
        $create = $this->service->delete($badObject);
    }

}