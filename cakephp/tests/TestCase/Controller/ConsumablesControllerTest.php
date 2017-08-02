<?php
namespace App\Test\TestCase\Controller;

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
        $this->get('/eventos/1/consumables');
        $this->assertResponseOK();
        $this->assertResponseContains('<h3 data-id=1> Evento Teste Fixture (1) > Consumíveis</h3>');
        $this->assertResponseContains('<b data-bind="visible: !editing(), text: nome, click: edit">&nbsp;</b>');
        
        //TODO essa página tem execução de js para preencher os consumíveis
        //Melhor testar com Selenium
    }

    public function testView_html() {
        $this->get('/eventos/1/consumables/view/1');
        $this->assertResponseOK();
        $this->assertResponseContains('<h3>Consumable Fixture (1)</h3>');

    }

    public function testAdd_html() {
        $data = ['nome'=>'Consumable Teste','eventos_id'=> 1];

        $query = $this->Consumables->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(0, $query->count());

        $this->post('/eventos/1/consumables/add',$data);
        $this->assertResponseSuccess();

        $query = $this->Consumables->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(1, $query->count());
    }
    
     public function testAdd_json() {
        $data = ['nome'=>'Consumable Teste','eventos_id'=> 1];

        $query = $this->Consumables->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(0, $query->count());
        
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
        
        $this->post('/api/consumables.json',json_encode($data));
        $this->assertResponseSuccess();

        $query = $this->Consumables->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(1, $query->count());
    }

    public function testEdit_html() {
        $data = ['nome'=>'Consumable Edit'];

        $query = $this->Consumables->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(0, $query->count());

        $current = $this->Consumables->get(1);
        $this->assertEquals("Consumable Fixture",$current->nome);

        $this->put('/eventos/1/consumables/edit/1',$data);
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
        $this->put('/api/consumables/1.json',$data);
        $this->assertResponseSuccess();

        $query = $this->Consumables->find()->where(['nome' => 'Teste Edit']);
        $this->assertEquals(1, $query->count());
        $current = $this->Consumables->get(1);
        $this->assertEquals("Teste Edit",$current->nome);
    }
    
    public function testDelete_html() {

        $query = $this->Consumables->find()->where(['nome' => "Consumable Fixture"]);
        $this->assertEquals(1, $query->count());

        $this->post('/eventos/1/consumables/delete/1');
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
