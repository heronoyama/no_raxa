<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TodoListsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class TodoListsTableTest extends TestCase {

    public $TodoLists;

    public $fixtures = [
        'app.todo_lists'
    ];

    public function setUp() {
        parent::setUp();
        $config = TableRegistry::exists('TodoLists') ? [] : ['className' => TodoListsTable::class];
        $this->TodoLists = TableRegistry::get('TodoLists', $config);
    }

    public function tearDown() {
        unset($this->TodoLists);

        parent::tearDown();
    }

    public function testValidationDefault() {
        $data = [
            'nome' => 'Teste',
        ];

        $todoList = $this->TodoLists->newEntity($data);
        $this->assertEmpty($todoList->errors());
    }

    public function testSuccessfulCreation() {
        $data = [
            'nome' => 'Teste',
        ];

        $this->assertQuantidadeRegistros(1); 
        //1 proveniente da fixture. 
        //TOSOLVE
     
        $todoList = $this->TodoLists->newEntity($data);
        $result = $this->TodoLists->save($todoList);
        $this->assertEmpty($todoList->errors());
        $this->assertQuantidadeRegistros(2);
        //1 proveniente da fixture. 
        //TOSOLVE

        $savedTodoList = $this->TodoLists->get(2);
        $this->assertEquals(2,$savedTodoList->id);
        $this->assertEquals('Teste',$savedTodoList->nome);
    }

    public function testEmptyName() {
        $data = [
            'nome' => '',
        ];

        $this->assertQuantidadeRegistros(1);
        //1 proveniente da fixture. 
        //TOSOLVE

        $todoList = $this->TodoLists->newEntity($data);
        $this->assertNotEmpty($todoList->errors());

        $this->assertQuantidadeRegistros(1);
        //1 proveniente da fixture. 
        //TOSOLVE
    }

    private function assertQuantidadeRegistros($quantidade){
        $allTodoLists = $this->TodoLists->find('all');
        $this->assertEquals($allTodoLists->count(),$quantidade,"Deveria ter ".$quantidade." de registros criados");
    }
}
