<?php

/**
 * Test class for HomeNet_NodeModelController.
 * Generated by PHPUnit on 2012-04-27 at 14:47:34.
 */
class HomeNet_NodeModelControllerTest extends CMS_Test_PHPUnit_ControllerTestCase {

    private $service;
    private $installer;
    private $homenetInstaller;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->installer = new Core_Installer();
        $this->installer->installTest();
        $this->installer->loginAsSuperAdmin();


        $this->bootstrap = new Zend_Application('testing', APPLICATION_PATH . '/configs/application.ini'); //
        $this->view = Zend_Registry::get('view');

        //$this->homenetInstaller = new HomeNet_Installer();
        // $this->homenetInstaller->uninstallTest();
        //$this->homenetInstaller->installTest(array('house','room'));

        $this->service = new HomeNet_Model_NodeModel_Service();
        $this->service->deleteAll();
        parent::setUp();

        $request = $this->getRequest();
        $this->setModule('HomeNet');
        $this->setController('NodeModel');
    }

////////////////////////////////////////////////////////////////////////////////////////////  
////////////////////////////////////////////////////////////////////////////////////////////    
//from service test, good use for traits once we go to 5.4

    protected function _getTestData($seed = 0) {

        $array = array('type' => HomeNet_Model_Node::SENSOR,
            'status' => HomeNet_Model_NodeModel::LIVE,
            'network_types' => array($seed),
            //   'devices' => array(array('position'=>1,'model'=>1,'name'=>'test', 'settings'=>array('key'=>$seed))),
            'plugin' => 'Arduino',
            'name' => 'testModel' . $seed,
            'description' => 'test description' . $seed,
            'image' => 'test.jpg' . $seed,
            'max_devices' => 1 + $seed,
                //   'settings' => array('key' => 'value'.$seed)
        );

        if ($seed % 2 == 0) {
            $array['type'] = HomeNet_Model_Node::INTERNET;
            $array['status'] = HomeNet_Model_NodeModel::TESTING;
            $array['plugin'] = 'Jeenode';
        }
        return $array;
    }

    protected function _createValidObject($seed = 0) {
        $object = new HomeNet_Model_NodeModel();
        $object = $this->_fillObject($object, $seed);

        $result = $this->service->create($object);

        $this->assertInstanceOf('HomeNet_Model_NodeModel_Interface', $result);
        return $result;
    }

//end
////////////////////////////////////////////////////////////////////////////////////////////  
////////////////////////////////////////////////////////////////////////////////////////////    

    private function _getBadTestData($version = 0) {

        $array = $this->_getTestData();
        if ($version == 0) {
            $array['name'] = '';
        }
        return $array;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

//    /**
//     * @todo Implement testInit().
//     */
//    public function testInit() {
//
//    }

    public function testIndexAction() {
        $object = $this->_createValidObject();
        $this->setAction('Index');

        //run
        $this->dispatch();

        $this->assertACM();
        $this->assertContains($object->name, $this->response->outputBody());
    }

    public function testNewAction_firstView() {
        //setup
        $this->setAction('New');

        //run
        $this->dispatch();

        $this->assertACM();
        $this->assertNotRedirect();
    }

    public function testNewAction_submitInvalid() {
        //setup
        $this->setAction('New');

        $this->getRequest()->setMethod('POST')
                ->setPost($this->_getBadTestData());

        //run
        $this->dispatch();

        $this->assertACM();
        $this->assertNotRedirect();
    }

    public function testNewAction_submitValid() {
        //setup
        $this->setAction('New');
        $this->getRequest()->setMethod('POST')
                ->setPost($this->_getTestData());

        //run
        $this->dispatch();

        $this->assertACM();
        $this->assertRedirect();
    }

    public function testEditAction_firstView() {
        //setup
        $object = $this->_createValidObject();
        $this->setAction('Edit');
        $this->getRequest()->setParam('id', $object->id);

        //run
        $this->dispatch();
        $this->assertACM();
        $this->assertContains($object->name, $this->response->outputBody()); //make sure data is in the form
        $this->assertNotRedirect();
    }

    public function testEditAction_submitInvalid() {
        //setup
        $object = $this->_createValidObject();
        $this->setAction('Edit');
        $this->getRequest()->setParam('id', $object->id);
        $this->getRequest()->setMethod('POST')
                ->setPost($this->_getBadTestData());
        //run
        $this->dispatch();

        $this->assertACM();
        $this->assertNotRedirect();
    }

    public function testEditAction_submitValid() {
        //setup
        $object = $this->_createValidObject();
        $this->setAction('Edit');
        $this->getRequest()->setParam('id', $object->id);
        $this->getRequest()->setMethod('POST')
                ->setPost($this->_getTestData(1));

        //run
        $this->dispatch();

        $this->assertACM();
        $this->assertRedirect();
    }

    public function testDeleteAction_firstView() {
        //setup
        $object = $this->_createValidObject();
        $this->setAction('Delete');
        $this->getRequest()->setParam('id', $object->id);

        //show form
        $this->dispatch();

        $this->assertACM();
        $this->assertContains($object->name, $this->response->outputBody()); //make sure data is in the form
        $this->assertNotRedirect();
    }

    public function testDeleteAction_submitCancel() {
        //setup
        $object = $this->_createValidObject();
        $this->setAction('Delete');
        $this->getRequest()->setParam('id', $object->id);
        $this->getRequest()->setMethod('POST')
                ->setPost(array('cancel' => 'cancel'));

        //run
        $this->dispatch();
        $this->assertACM();
        $this->assertRedirect();
    }

    public function testDeleteAction_submitDelete() {
        //setup
        $object = $this->_createValidObject();
        $this->setAction('Delete');
        $this->getRequest()->setParam('id', $object->id);
        $this->getRequest()->setMethod('POST')
                ->setPost(array('confirm' => 'confirm'));

        //run
        $this->dispatch();
        $this->assertACM();
        $this->assertRedirect();
    }

}