<?php
namespace App\Test\TestCase\Controller;

use App\Controller\TodoListsController;
use Cake\TestSuite\IntegrationTestCase;
use App\Model\Table\TodoListsTable;
use App\Model\Table\ActivitiesTable;
use Cake\ORM\TableRegistry;



class TodoListsControllerTest extends IntegrationTestCase {

    public $fixtures = [
        'app.todo_lists',
        'app.activities'
    ];
    
    public function setUp() {
        parent::setUp();
        $config = TableRegistry::exists('TodoLists') ? [] : ['className' => TodoListsTable::class];
        $this->TodoLists = TableRegistry::get('TodoLists', $config);

        $config = TableRegistry::exists('Activities') ? [] : ['className' => ActivitiesTable::class];
        $this->Activities = TableRegistry::get('Activities', $config);
    }

    public function testIndex_html() {
        $this->get('/todo-lists');
        $this->assertResponseOK();
        $this->assertResponseContains('Lorem ipsum dolor sit amet');
    }

    public function testIndex_json(){
        $this->get('/api/todo_lists.json');
        $this->assertResponseOK();
        $this->assertHeader('Content-type','application/json; charset=UTF-8','Resposta deveria ser json');

        $this->assertResponseContains('"nome": "Lorem ipsum dolor sit amet"');
    }

    public function testView_html() {
        $this->get('/todo-lists/view/1');
        $this->assertResponseOK();
        $this->assertResponseContains('<h3>Lorem ipsum dolor sit amet</h3>');

    }

    public function testView_json(){
        $this->get('/api/todo_lists/1.json');
        $this->assertResponseOK();
        $this->assertHeader('Content-type','application/json; charset=UTF-8','Resposta deveria ser json');
        $this->assertResponseContains('"nome": "Lorem ipsum dolor sit amet"');
        $this->assertResponseContains('"nome": "Activity: Lorem ipsum dolor sit amet"');
    }

    public function testAdd_html() {
        $data = ['nome'=>'TodoList 2'];

        $query = $this->TodoLists->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(0, $query->count());

        $this->post('/todo-lists/add',$data);
        $this->assertResponseSuccess();

        $query = $this->TodoLists->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(1, $query->count());
    }

    public function testAdd_json() {
        $query = $this->TodoLists->find()->where(['nome' => 'Teste REST']);
        $this->assertEquals(0, $query->count());

        
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
 
        $data = "{\"nome\":\"Teste REST\"}";

        $this->post('/api/todo_lists.json',json_encode($data));
        $this->assertResponseSuccess();

        $query = $this->TodoLists->find()->where(['nome' => 'Teste REST']);
        $this->assertEquals(1, $query->count());
    }


    public function testEdit_html() {
        $data = ['nome'=>'TODO Edit'];

        $query = $this->TodoLists->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(0, $query->count());

        $current = $this->TodoLists->get(1);
        $this->assertEquals("Lorem ipsum dolor sit amet",$current->nome);

        $this->put('/todo-lists/edit/1',$data);
        $this->assertResponseSuccess();

        $query = $this->TodoLists->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(1, $query->count());
        $current = $this->TodoLists->get(1);
        $this->assertEquals("TODO Edit",$current->nome);
    }

    public function testEdit_json() {
        $query = $this->TodoLists->find()->where(['nome' => 'Teste Edit']);
        $this->assertEquals(0, $query->count());

        $current = $this->TodoLists->get(1);
        $this->assertEquals("Lorem ipsum dolor sit amet",$current->nome);

         $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
 
        $data = "{\"nome\":\"Teste Edit\"}";
        $this->put('/api/todo_lists/1.json',json_encode($data));
        $this->assertResponseSuccess();

        $query = $this->TodoLists->find()->where(['nome' => 'Teste Edit']);
        $this->assertEquals(1, $query->count());
        $current = $this->TodoLists->get(1);
        $this->assertEquals("Teste Edit",$current->nome);
    }
  
    public function testDelete_html() {

        $query = $this->TodoLists->find()->where(['nome' => "Lorem ipsum dolor sit amet"]);
        $this->assertEquals(1, $query->count());

        $this->post('/todo-lists/delete/1');
        $this->assertResponseSuccess();

        $query = $this->TodoLists->find()->where(['nome' => "Lorem ipsum dolor sit amet"]);
        $this->assertEquals(0, $query->count());
    }

    public function testDelete_json() {

        $query = $this->TodoLists->find()->where(['nome' => "Lorem ipsum dolor sit amet"]);
        $this->assertEquals(1, $query->count());

        $this->delete('/api/todo_lists/1.json');
        $this->assertResponseSuccess();

        $query = $this->TodoLists->find()->where(['nome' => "Lorem ipsum dolor sit amet"]);
        $this->assertEquals(0, $query->count());
    }

    public function testAddActivity_html(){
        $query = $this->Activities->find('all');
        $this->assertEquals(1,$query->count());

        $data = ['nome'=>'Atividade nova'];
        $this->post('/todo-lists/add-activity/1',$data);
        $this->assertResponseSuccess();

        $query = $this->Activities->find('all');
        $this->assertEquals(2,$query->count());

        $activity = $this->Activities->get(2);
        $this->assertEquals("Atividade nova",$activity->nome);
    }

    public function testAddActivity_json(){

        $query = $this->Activities->find('all');
        $this->assertEquals(1,$query->count());

        
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
 
        $data = "{\"nome\":\"Atividade Nova\"}";
        $this->post('/api/todo_lists/add_activity/1.json',json_encode($data));
        $this->assertResponseSuccess();

        $query = $this->Activities->find('all');
        $this->assertEquals(2,$query->count());

        $activity = $this->Activities->get(2);
        $this->assertEquals("Atividade Nova",$activity->nome);

    }
}