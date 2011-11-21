<?php

/**
 * Test class for IndexController.
 * Generated by PHPUnit on 2011-11-17 at 05:57:25.
 */
class IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase {

    /**
     * @var IndexController
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        Core_Model_Installer::install();
        $this->bootstrap = new Zend_Application('testing', APPLICATION_PATH . '/configs/application.ini'); 
        
        $this->view = Zend_Registry::get('view');

        parent::setUp();        

        $request = $this->getRequest();
        $request->setModuleName('Core');
        $request->setControllerName('Index');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        Core_Model_Installer::uninstall();
    }

    /**
     * @todo Implement testIndexAction().
     */
    public function testIndexAction() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testTestAction() {
        //setup
        $this->getRequest()->setActionName('Test');
        
        
        
        //run
        $this->dispatch();

       // $this->assertModule('Core');
        $this->assertController('Index');
        $this->assertAction('Test');
        $this->assertNotRedirect();
    }

    public function testWidgetAction() {
        //setup
        $this->getRequest()->setActionName('Widget');
        
        //run
        $this->dispatch();
      //  $this->assertModule('Core');
        $this->assertController('Index');
        $this->assertAction('Widget');
        $this->assertNotRedirect();
    }    
}

?>
