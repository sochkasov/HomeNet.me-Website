<?php

/**
 * Test class for Core_Model_Acl_Service.
 * Generated by PHPUnit on 2011-06-27 at 19:48:52.
 */
class Core_Model_Acl_ManagerTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Core_Model_Acl_Service
     */
    protected $manager;
    
    protected $installer;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        
        $this->installer = new Core_Installer();
        $this->installer->installTest();

        //$uService = new Core_Model_User_Service();
        //$user = $uService->getObjectById();
        
        $this->manager = new Core_Model_Acl_Manager($this->installer->user->member);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }


    public function testSetUser() {
        $user = new Core_Model_User();
        $this->manager->setUser($user);
        
        $this->assertInstanceOf('Core_Model_User', $this->manager->getUser());
        
    }

    public function testGetResources() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testGetResourcesByModule() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }
    
    public function testGetBaseAcl(){
        $result = $this->manager->getBaseAcl('core');
        $this->assertInstanceOf('CMS_Acl', $result);
    }

    
    public function testGetGroupAcl() {
        $uService = new Core_Model_User_Service();
        //$user = $uService->getObjectById(Core_Model_Installer::$userGuest);
        
        $this->manager = new Core_Model_Acl_Manager($this->installer->user->guest);
        
        
        $result = $this->manager->getGroupAcl('core');
        $this->assertInstanceOf('Zend_Acl', $result);
        $this->assertTrue($result->isAllowed($this->installer->group->guests, new CMS_Acl_Resource_Controller('index')));
         
         
    }
    
    
    public function testGetUserAcl() {
        $result = $this->manager->getUserAcl('core');
        $this->assertInstanceOf('Zend_Acl', $result);
        $this->assertTrue($result->isAllowed($this->installer->user->member, new CMS_Acl_Resource_Controller('index')));
    }


    public function testGetGroupAclObjects() {
        $result = $this->manager->getGroupAclObjects('test','group',array(1,2,3));
        $this->assertInstanceOf('Zend_Acl', $result);
        
        $this->assertTrue ($result->isAllowed($this->installer->group->members, new CMS_Acl_Resource_Controller('group'),'index'));
        $this->assertFalse($result->isAllowed($this->installer->group->members, new CMS_Acl_Resource_Controller('group'),'edit'));
        $this->assertTrue ($result->isAllowed($this->installer->group->members, new CMS_Acl_Resource_Controller('group'),'add'));
        $this->assertTrue ($result->isAllowed($this->installer->group->members, new CMS_Acl_Resource_Object('group',1),'edit'));
        $this->assertFalse($result->isAllowed($this->installer->group->members, new CMS_Acl_Resource_Object('group',2),'edit'));
        $this->assertFalse($result->isAllowed($this->installer->group->members, new CMS_Acl_Resource_Object('group',3),'edit'));
        
        
    }


    public function testGetUserAclObjects() {
        $result = $this->manager->getUserAclObjects('test', 'user', array(1, 2, 3));
        $this->assertInstanceOf('Zend_Acl', $result);

        $this->assertTrue ($result->isAllowed($this->installer->user->member, new CMS_Acl_Resource_Controller('user'), 'index'));
        $this->assertFalse($result->isAllowed($this->installer->user->member, new CMS_Acl_Resource_Controller('user'), 'edit'));
        $this->assertTrue ($result->isAllowed($this->installer->user->member, new CMS_Acl_Resource_Controller('user'), 'add'));
        $this->assertTrue ($result->isAllowed($this->installer->user->member, new CMS_Acl_Resource_Object('user', 1), 'edit'));
        $this->assertFalse($result->isAllowed($this->installer->user->member, new CMS_Acl_Resource_Object('user', 2), 'edit'));
        $this->assertFalse($result->isAllowed($this->installer->user->member, new CMS_Acl_Resource_Object('user', 3), 'edit'));
    }
    
    
    public function testGetUserAclCollection() {
        $result = $this->manager->getUserAclCollection('test', 1);
        $this->assertInstanceOf('Zend_Acl', $result);

        $this->assertTrue ($result->isAllowed($this->installer->user->member, new CMS_Acl_Resource_Controller('user'), 'index'));
        $this->assertFalse($result->isAllowed($this->installer->user->member, new CMS_Acl_Resource_Controller('user'), 'edit'));
        $this->assertTrue ($result->isAllowed($this->installer->user->member, new CMS_Acl_Resource_Controller('user'), 'add'));
        $this->assertTrue ($result->isAllowed($this->installer->user->member, new CMS_Acl_Resource_Object('user', 1), 'edit'));
        $this->assertFalse($result->isAllowed($this->installer->user->member, new CMS_Acl_Resource_Object('user', 2), 'edit'));
        $this->assertFalse($result->isAllowed($this->installer->user->member, new CMS_Acl_Resource_Object('user', 3), 'edit'));
    }
    
    
    public function testUserMemberAllowed(){
        $result = $this->manager->getUserAcl('core');
        $this->assertInstanceOf('Zend_Acl', $result);
        $this->assertTrue($result->isAllowed($this->installer->user->member, new CMS_Acl_Resource_Controller('index'),'index'));
        $this->assertTrue($result->isAllowed($this->installer->user->member, new CMS_Acl_Resource_Controller('user'),'add'));
    }
    
    public function testUserMemberDenied(){
        $result = $this->manager->getUserAcl('core');
        $this->assertFalse($result->isAllowed($this->installer->user->member, new CMS_Acl_Resource_Controller('login'),'index'));
    }
    public function testUserMemberInvalidControllerDenied(){
        $result = $this->manager->getUserAcl('core');
        $this->assertFalse($result->isAllowed($this->installer->user->member, new CMS_Acl_Resource_Controller('notInPermissions'),'index'));
    }
    
    public function testGroupMemberAllowed(){
         $result = $this->manager->getGroupAcl('core');
        $this->assertInstanceOf('Zend_Acl', $result);
        $this->assertTrue($result->isAllowed($this->installer->group->members, new CMS_Acl_Resource_Controller('index')));
    }
    
    public function testGroupMemberDenied(){
         $result = $this->manager->getGroupAcl('core');
        $this->assertInstanceOf('Zend_Acl', $result);
        $this->assertFalse($result->isAllowed($this->installer->group->members, new CMS_Acl_Resource_Controller('login')));
    }
    public function testModuleDoesNotExistIsDenied(){
        $result = $this->manager->getUserAcl('core');
        $this->assertFalse($result->isAllowed($this->installer->user->member, new CMS_Acl_Resource_Controller('notInPermissions'),'index'));
    }

}