<?php
namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;
use App\Model\Table\EventosTable;
use App\Model\Table\ConsumablesTable;
use Cake\ORM\TableRegistry;

class EventosControllerTest extends IntegrationTestCase {

    public $fixtures = [
        'app.eventos',
        'app.consumables'
    ];
 
    public function setUp() {
        parent::setUp();
        $config = TableRegistry::exists('Eventos') ? [] : ['className' => EventosTable::class];
        $this->Eventos = TableRegistry::get('Eventos', $config);

        $config = TableRegistry::exists('Consumables') ? [] : ['className' => ConsumablesTable::class];
        $this->Consumables = TableRegistry::get('Consumables', $config);
    }

    public function testIndex_html() {
        $this->get('/eventos');
        $this->assertResponseOK();
        $this->assertResponseContains('<td>Evento Teste Fixture</td>');
    }

    public function testView_html() {
        $this->get('/eventos/view/1');
        $this->assertResponseOK();
        $this->assertResponseContains('<h3 data-id=1> Evento Teste Fixture (1)</h3>');

    }

    public function testView_json(){
        $this->get('/api/eventos/1.json');
        $this->assertResponseOK();
        $this->assertHeader('Content-type','application/json; charset=UTF-8','Resposta deveria ser json');
        $this->assertResponseContains('"nome": "Evento Teste Fixture"');
    }

    public function testAdd_html() {
        $data = ['nome'=>'Evento Teste','data'=>'2017-07-29 17:00:00'];

        $query = $this->Eventos->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(0, $query->count());

        $this->post('/eventos/add',$data);
        $this->assertResponseSuccess();

        $query = $this->Eventos->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(1, $query->count());
    }
    public function testEdit_html() {
        $data = ['nome'=>'Evento Edit'];

        $query = $this->Eventos->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(0, $query->count());

        $current = $this->Eventos->get(1);
        $this->assertEquals("Evento Teste Fixture",$current->nome);

        $this->put('/eventos/edit/1',$data);
        $this->assertResponseSuccess();

        $query = $this->Eventos->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(1, $query->count());
        $current = $this->Eventos->get(1);
        $this->assertEquals("Evento Edit",$current->nome);
    }
    
    public function testDelete_html() {

        $query = $this->Eventos->find()->where(['nome' => "Evento Teste Fixture"]);
        $this->assertEquals(1, $query->count());

        $this->post('/eventos/delete/1');
        $this->assertResponseSuccess();

        $query = $this->Eventos->find()->where(['nome' => "Evento Teste Fixture"]);
        $this->assertEquals(0, $query->count());
    }

    public function testAddConsumable_json(){

        $query = $this->Consumables->find('all');
        $this->assertEquals(1,$query->count());

        
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
 
        $data = "{\"nome\":\"Consumable Novo\"}";
        $this->post('/api/eventos/add_consumable/1.json',json_encode($data));
        $this->assertResponseSuccess();

        $query = $this->Consumables->find('all');
        $this->assertEquals(2,$query->count());

        $activity = $this->Consumables->get(2);
        $this->assertEquals("Consumable Novo",$activity->nome);

    }
    
}
