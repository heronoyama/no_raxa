<?php
namespace App\Test\TestCase\Controller;

use App\Controller\ConsumablesController;
use Cake\TestSuite\IntegrationTestCase;
use App\Model\Table\ConsumablesTable;
use Cake\ORM\TableRegistry;

class ConsumablesControllerTest extends IntegrationTestCase {

    public $fixtures = [
        'app.consumables',
        'app.eventos'
    ];

     public function setUp() {
        parent::setUp();
        $config = TableRegistry::exists('Consumables') ? [] : ['className' => ConsumablesTable::class];
        $this->Consumables = TableRegistry::get('Consumables', $config);
    }
    
    public function testIndex_html() {
        $this->get('/consumables');
        $this->assertResponseOK();
        $this->assertResponseContains('<td>Consumable Fixture</td>');
        $this->assertResponseContains('<a href="/eventos/view/1">Evento Teste Fixture</a>');
    }

    public function testIndex_json(){
        $this->get('/api/consumables.json');
        $this->assertResponseOK();
        $this->assertHeader('Content-type','application/json; charset=UTF-8','Resposta deveria ser json');

        $this->assertResponseContains('"nome": "Consumable Fixture"');
        $this->assertResponseContains('"eventos_id": 1');
    }

    public function testView_html() {
        $this->get('/consumables/view/1');
        $this->assertResponseOK();
        $this->assertResponseContains('<h3>Consumable Fixture (1)</h3>');

    }

    public function testView_json(){
        $this->get('/api/consumables/1.json');
        $this->assertResponseOK();
        $this->assertHeader('Content-type','application/json; charset=UTF-8','Resposta deveria ser json');
        $this->assertResponseContains('"nome": "Consumable Fixture"');
    }

    public function testAdd_html() {
        $data = ['nome'=>'Consumable Teste','eventos_id'=> 1];

        $query = $this->Consumables->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(0, $query->count());

        $this->post('/consumables/add',$data);
        $this->assertResponseSuccess();

        $query = $this->Consumables->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(1, $query->count());
    }

    public function testAdd_json() {
        $query = $this->Consumables->find()->where(['nome' => 'Teste REST']);
        $this->assertEquals(0, $query->count());

        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
 
        $data = "{\"nome\":\"Teste REST\",\"eventos_id\":1}";

        $this->post('/api/consumables.json',json_encode($data));
        $this->assertResponseSuccess();

        $query = $this->Consumables->find()->where(['nome' => 'Teste REST']);
        $this->assertEquals(1, $query->count());
    }
    
    public function testEdit_html() {
        $data = ['nome'=>'Consumable Edit'];

        $query = $this->Consumables->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(0, $query->count());

        $current = $this->Consumables->get(1);
        $this->assertEquals("Consumable Fixture",$current->nome);

        $this->put('/consumables/edit/1',$data);
        $this->assertResponseSuccess();

        $query = $this->Consumables->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(1, $query->count());
        $current = $this->Consumables->get(1);
        $this->assertEquals("Consumable Edit",$current->nome);
    }
    
    public function testEdit_json() {
        $query = $this->Consumables->find()->where(['nome' => 'Teste Edit']);
        $this->assertEquals(0, $query->count());

        $current = $this->Consumables->get(1);
        $this->assertEquals("Consumable Fixture",$current->nome);

         $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
 
        $data = "{\"nome\":\"Teste Edit\"}";
        $this->put('/api/consumables/1.json',json_encode($data));
        $this->assertResponseSuccess();

        $query = $this->Consumables->find()->where(['nome' => 'Teste Edit']);
        $this->assertEquals(1, $query->count());
        $current = $this->Consumables->get(1);
        $this->assertEquals("Teste Edit",$current->nome);
    }
    
    public function testDelete_html() {

        $query = $this->Consumables->find()->where(['nome' => "Consumable Fixture"]);
        $this->assertEquals(1, $query->count());

        $this->post('/consumables/delete/1');
        $this->assertResponseSuccess();

        $query = $this->Consumables->find()->where(['nome' => "Consumable Fixture"]);
        $this->assertEquals(0, $query->count());
    }

    public function testDelete_json() {

        $query = $this->Consumables->find()->where(['nome' => "Consumable Fixture"]);
        $this->assertEquals(1, $query->count());

        $this->delete('/api/consumables/1.json');
        $this->assertResponseSuccess();

        $query = $this->Consumables->find()->where(['nome' => "Consumable Fixture"]);
        $this->assertEquals(0, $query->count());
    }
}
