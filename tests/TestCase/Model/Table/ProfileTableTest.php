<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProfileTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProfileTable Test Case
 */
class ProfileTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProfileTable
     */
    public $Profile;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.profile',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Profile') ? [] : ['className' => ProfileTable::class];
        $this->Profile = TableRegistry::get('Profile', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Profile);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
