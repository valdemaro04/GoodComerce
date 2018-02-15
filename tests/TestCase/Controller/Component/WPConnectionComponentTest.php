<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\WPConnectionComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\WPConnectionComponent Test Case
 */
class WPConnectionComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\WPConnectionComponent
     */
    public $WPConnection;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->WPConnection = new WPConnectionComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WPConnection);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
