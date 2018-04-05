<?php
namespace API\Test\TestCase\Model\Table;

use API\Model\Table\MoviesUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * API\Model\Table\MoviesUsersTable Test Case
 */
class MoviesUsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \API\Model\Table\MoviesUsersTable
     */
    public $MoviesUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.API.movies_users',
        'plugin.API.users',
        'plugin.API.roles',
        'plugin.API.movies',

    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MoviesUsers') ? [] : ['className' => MoviesUsersTable::class];
        $this->MoviesUsers = TableRegistry::get('MoviesUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MoviesUsers);

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
