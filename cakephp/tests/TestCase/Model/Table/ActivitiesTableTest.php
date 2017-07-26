<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ActivitiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class ActivitiesTableTest extends TestCase {


    public $Activities;

    public $fixtures = [
        'app.todo_lists',
        'app.activities'
    ];


    public function setUp() {
        parent::setUp();
        $config = TableRegistry::exists('Activities') ? [] : ['className' => ActivitiesTable::class];
        $this->Activities = TableRegistry::get('Activities', $config);
    }

    public function tearDown() {
        unset($this->Activities);

        parent::tearDown();
    }

    public function testValidationDefault() {
        $data = [
            'nome' => 'Teste',
            'todo_lists_id' =>1
        ];

        $activity = $this->Activities->newEntity($data);
        $this->assertEmpty($activity->errors());
    }

    public function testNaoCriaSemNome() {
        $data = [
            'todo_lists_id' =>1
        ];

        $activity = $this->Activities->newEntity($data);
        $this->assertNotEmpty($activity->errors());

        $message = $this->getMessageError('nome','_required',$activity->errors());
        $this->assertEquals($message,'Uma atividade deve ter um nome.');
    }

    public function testNaoCriaNomeVazio() {
        $data = [
            'nome' =>'',
            'todo_lists_id' =>1
        ];

        $activity = $this->Activities->newEntity($data);
        $this->assertNotEmpty($activity->errors());

        $message = $this->getMessageError('nome','_empty',$activity->errors());
        $this->assertEquals($message,'Uma atividade deve ter um nome.');
    }

     public function testNaoCriaSemLista() {
        $data = [
            'nome' =>'Teste'
        ];

        $activity = $this->Activities->newEntity($data);
        $this->assertNotEmpty($activity->errors());

        $message = $this->getMessageError('todo_lists_id','_required',$activity->errors());
        $this->assertEquals($message,'Uma atividade deve estar associada à uma lista.');
    }

    public function testNaoCriaListaVazia() {
        $data = [
            'nome' =>'Teste',
            'todo_lists_id' => ''
        ];

        $activity = $this->Activities->newEntity($data);
        $this->assertNotEmpty($activity->errors());

        $message = $this->getMessageError('todo_lists_id','_empty',$activity->errors());
        $this->assertEquals($message,'Uma atividade deve estar associada à uma lista.');
    }

    public function testSalvaAtividade(){
        $data = [
        'nome' => 'Teste',
        'todo_lists_id' => 1
        ];
        
        $activity = $this->Activities->newEntity($data);
        $this->assertEmpty($activity->errors());
        $this->Activities->save($activity);


        $recoveredActivity = $this->Activities->get(2);
        $this->assertEquals($recoveredActivity->id,2); //A primeira veio da fixture
        $this->assertEquals($recoveredActivity->nome,'Teste');
        $this->assertFalse($recoveredActivity->concluded);


    }

    private function getMessageError($attribute,$key,$errors){
        return $errors[$attribute][$key];
    }

}
