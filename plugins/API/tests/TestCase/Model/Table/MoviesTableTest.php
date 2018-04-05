<?php
namespace API\Test\TestCase\Model\Table;

use API\Model\Table\MoviesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * API\Model\Table\MoviesTable Test Case
 */
class MoviesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \API\Model\Table\MoviesTable
     */
    public $Movies;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.API.movies',
        'plugin.API.users',
        'plugin.API.roles',
        'plugin.API.movies_users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Movies') ? [] : ['className' => MoviesTable::class];
        $this->Movies = TableRegistry::get('Movies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Movies);

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
