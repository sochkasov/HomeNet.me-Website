<?php

require_once dirname(__FILE__) . '/../../../../application/models/User/Manager.php';

/**
 * Test class for Core_Model_User_Manager.
 * Generated by PHPUnit on 2011-06-24 at 18:33:45.
 */
class Core_Model_User_ManagerTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Core_Model_User_Manager
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        Core_Model_Installer::install();
        $this->object = new Core_Model_User_Manager;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        Core_Model_Installer::uninstall();
    }

    private function createValidUser() {
        $register = array(
            'primary_group' => Core_Model_Installer::$groupMember,
            'username' => 'testUsername',
            'name' => 'testName',
            'location' => 'testLocation',
            'email' => 'test@test.com',
            'password' => 'Test123!');
        $result = $this->object->register($register);
        $this->object->setUser($result);
        return $result;
    }

    /**
     * @todo Implement testSetAuthClass().
     */
    public function testSetAuthClass() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testLogin() {
        $this->createValidUser();
        $this->object->login(array('username' => 'testUsername', 'password' => 'Test123!'));

        $this->assertNotEmpty($_SESSION['User']);
        //validate that it is the right group and such
    }

    

    public function testRegisterValid() {
        $result = $this->createValidUser();

        $this->assertInstanceOf('Core_Model_User_Interface', $result);

        $this->assertNotNull($result->id);
        $this->assertEquals(0, $result->status);
        $this->assertEquals(Core_Model_Installer::$groupMember, $result->primary_group);
        $this->assertEquals('testUsername', $result->username);
        $this->assertEquals('testName', $result->name);
        $this->assertEquals('testLocation', $result->location);
        $this->assertEquals('test@test.com', $result->email);
    }

    public function testRegisterInvalid() {
        $result = $this->createValidUser();
        $this->object->clearUser();
        $this->setExpectedException('DuplicateEntryException');
        $result = $this->createValidUser();

//        $register = array(
//            
//             'username' => 'testUsername',
//            'name' => 'testName',
//            'location' => 'testLocation',
//            'email' => 'test@test.com',
//             'password' => 'test');
//        
//        //
//         $result = $this->object->register($register);
    }

    /**
     * @todo Implement testChangePassword().
     */
    public function testChangePassword() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testSendActivationEmail() {

        $result = $this->createValidUser();
        $this->object->sendActivationEmail();

        $this->assertNotNull($result->getSetting('activationKey'));


        $this->assertFileExists(sys_get_temp_dir() . '/test@test.com.txt');
        unlink(sys_get_temp_dir() . '/test@test.com.txt');
        //sys_get_temp_dir();
        //check file where email should end up
    }

    public function testActivateCorrectKey() {
        $user = $this->createValidUser();
        $result = $this->object->activate($user->getSetting('activationKey'));
        $this->assertTrue($result);
    }

    public function testActivateInvaildKey() {
        $user = $this->createValidUser();
        $this->setExpectedException('Exception');
        $result = $this->object->activate('8738278ab5');
    }
    
    public function testLogout() {
        $this->createValidUser();
        $this->object->login(array('username' => 'testUsername', 'password' => 'Test123!'));
      //  $this->object->logout();
       // echo debugArray($_SESSION['User']);
      //  $this->assertEmpty($_SESSION['User']);
    }

}