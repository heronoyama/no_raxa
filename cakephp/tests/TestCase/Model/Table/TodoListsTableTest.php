<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TodoListsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TodoListsTable Test Case
 */
class TodoListsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TodoListsTable
     */
    public $TodoLists;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.todo_lists'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('TodoLists') ? [] : ['className' => TodoListsTable::class];
        $this->TodoLists = TableRegistry::get('TodoLists', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TodoLists);

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
}
