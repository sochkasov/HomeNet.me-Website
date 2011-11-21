<?php

/**
 * Test class for LoginController.
 * Generated by PHPUnit on 2011-11-17 at 05:57:24.
 */
class LoginControllerTest extends Zend_Test_PHPUnit_ControllerTestCase {

    /**
     * @var LoginController
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
         Core_Model_Installer::install();
        $this->bootstrap = new Zend_Application('testing', APPLICATION_PATH . '/configs/application.ini'); //
        $this->view = Zend_Registry::get('view');

        parent::setUp();

        $request = $this->getRequest();
        $request->setModuleName('Core');
        $request->setControllerName('Login');

        $this->service = new Content_Model_Template_Service();
        
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        Core_Model_Installer::uninstall();
    }




    public function testIndexAction() {
        //setup
        $this->getRequest()->setActionName('Index');
        
        //run
        $this->dispatch();      
        
      //  $this->assertModule('Core');
        $this->assertController('Login');
        $this->assertAction('Index');
        $this->assertNotRedirect();
    }

    /**
    public function testFacebookAction() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }


    public function testTwitterAction() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testGoogleAction() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testYahooAction() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testOpenIDAction() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testAimAction() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testSuccessAction() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }*/

    public function testLogoutAction() {
        //setup
        $this->getRequest()->setActionName('Logout');
        
        //run
        $this->dispatch();
        //$this->assertModule('core');
        $this->assertController('Login');
        $this->assertAction('Logout');
        $this->assertNotRedirect();
    }
}