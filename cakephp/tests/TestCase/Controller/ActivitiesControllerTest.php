<?php
namespace App\Test\TestCase\Controller;

use App\Controller\TodoListsController;
use Cake\TestSuite\IntegrationTestCase;
use App\Model\Table\ActivitiesTable;
use Cake\ORM\TableRegistry;


class ActivitiesControllerTest extends IntegrationTestCase {

     public $fixtures = [
        'app.todo_lists',
        'app.activities'
    ];
    
    public function setUp() {
        parent::setUp();
        $config = TableRegistry::exists('Activities') ? [] : ['className' => ActivitiesTable::class];
        $this->Activities = TableRegistry::get('Activities', $config);
    }

    public function testIndex_html() {
        $this->get('/activities');
        $this->assertResponseOK();
        $this->assertResponseContains('Lorem ipsum dolor sit amet');
    }
    
    public function testView_html() {
        $this->get('/activities/view/1');
        $this->assertResponseOK();
        $this->assertResponseContains('<td>Activity: Lorem ipsum dolor sit amet</td>');

    }

    public function testAdd_html() {
        $data = ['nome'=>'Nova Atividade','todo_lists_id'=>1];

        $query = $this->Activities->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(0, $query->count());

        $this->post('/activities/add',$data);
        $this->assertResponseSuccess();

        $query = $this->Activities->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(1, $query->count());
    }

    public function testEdit_html() {
        $data = ['nome'=>'Atividade Edit','todo_lists_id'=>1];

        $query = $this->Activities->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(0, $query->count());

        $current = $this->Activities->get(1);
        $this->assertEquals("Activity: Lorem ipsum dolor sit amet",$current->nome);

        $this->put('/activities/edit/1',$data);
        $this->assertResponseSuccess();

        $query = $this->Activities->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(1, $query->count());
        $current = $this->Activities->get(1);
        $this->assertEquals("Atividade Edit",$current->nome);
    }

    public function testDelete_html() {

        $query = $this->Activities->find()->where(['nome' => "Activity: Lorem ipsum dolor sit amet"]);
        $this->assertEquals(1, $query->count());

        $this->post('/activities/delete/1');
        $this->assertResponseSuccess();

        $query = $this->Activities->find()->where(['nome' => "Activity: Lorem ipsum dolor sit amet"]);
        $this->assertEquals(0, $query->count());
    }

}