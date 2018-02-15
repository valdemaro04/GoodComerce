<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ApiKeyTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ApiKeyTable Test Case
 */
class ApiKeyTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ApiKeyTable
     */
    public $ApiKey;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.api_key',
        'app.users',
        'app.profile'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ApiKey') ? [] : ['className' => ApiKeyTable::class];
        $this->ApiKey = TableRegistry::get('ApiKey', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ApiKey);

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
