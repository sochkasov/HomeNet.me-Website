<?php

require_once dirname(__FILE__).'/../../../../application/modules/HomeNet/Installer.php';

/**
 * Test class for HomeNet_Installer.
 * Generated by PHPUnit on 2011-11-29 at 15:38:15.
 */
class HomeNet_InstallerTest extends PHPUnit_Framework_TestCase {

    /**
     * @var HomeNet_Installer
     */
    protected $installer;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->installer = new HomeNet_Installer;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    public function testGetAdminBlocks() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testGetAdminLinks() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testGetOptionalContent() {
        $result = $this->installer->getOptionalContent();
        $this->assertTrue(is_array($result));
    }

    public function testInstallOptionalContent() {
        $this->installer->installOptionalContent($this->installer->getOptionalContent());
    }


    public function testInstallTest() {
        $this->installer->installTest();
    }


    public function testUninstallTest() {
        $this->installer->uninstallTest();
    }
}