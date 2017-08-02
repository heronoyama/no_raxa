<?php
namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;
use App\Model\Table\EventosTable;
use App\Model\Table\ConsumablesTable;
use Cake\ORM\TableRegistry;

class EventosControllerTest extends IntegrationTestCase {

    public $fixtures = [
        'app.eventos',
        'app.consumables',
        'app.participantes',
        'app.collaborations'
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

    public function testView_json_noParams(){
        $this->get('/api/eventos/1.json');
        $this->assertResponseOK();
        $this->assertHeader('Content-type','application/json; charset=UTF-8','Resposta deveria ser json');
        
        $responseJson = json_decode($this->_getBodyAsString());
        $evento = $responseJson->evento;
        $this->assertEquals("Evento Teste Fixture",$evento->nome);
        $this->assertTrue(isset($evento->participantes));
        $this->assertTrue(isset($evento->consumables));
        $this->assertTrue(isset($evento->collaborations));

    }
    
    public function testView_json_oneParam(){
        $this->get('/api/eventos/1.json?include=(Participantes)');
        $this->assertResponseOK();
        $this->assertHeader('Content-type','application/json; charset=UTF-8','Resposta deveria ser json');
        
        $responseJson = json_decode($this->_getBodyAsString());
        $evento = $responseJson->evento;
        $this->assertEquals("Evento Teste Fixture",$evento->nome);
        $this->assertTrue(isset($evento->participantes));
        $this->assertFalse(isset($evento->consumables));
        $this->assertFalse(isset($evento->collaborations));
    }
    
    public function testView_json_twoParam(){
        $this->get('/api/eventos/1.json?include=(Participantes,Consumables)');
        $this->assertResponseOK();
        $this->assertHeader('Content-type','application/json; charset=UTF-8','Resposta deveria ser json');
        
        $responseJson = json_decode($this->_getBodyAsString());
        $evento = $responseJson->evento;
        $this->assertEquals("Evento Teste Fixture",$evento->nome);
        $this->assertTrue(isset($evento->participantes));
        $this->assertTrue(isset($evento->consumables));
        $this->assertFalse(isset($evento->collaborations));
    }
    
    public function testView_json_paramWithError(){
        $this->get('/api/eventos/1.json?include=Consumables');
        $this->assertResponseError();
        $responseJson = json_decode($this->_getBodyAsString());
        $message= $responseJson->message;
        $this->assertEquals("O valor desse parametro deve estar entre parenteses",$message);
        
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
    
    public function testEdit_json(){
        $current = $this->Eventos->get(1);
        $this->assertEquals("Evento Teste Fixture",$current->nome);
        $this->assertEquals(1,$current->pessoas_previstas);
        
        
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
 
        $data = "{\"nome\":\"Novo Evento\",\"pessoas_previstas\":2}";
        $this->put('/api/eventos/1.json',$data);
        $this->assertResponseSuccess();

        $current = $this->Eventos->get(1);
        $this->assertEquals("Novo Evento",$current->nome);
        $this->assertEquals(2,$current->pessoas_previstas);

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
        $this->post('/api/eventos/add_consumable/1.json',$data);
        $this->assertResponseSuccess();

        $query = $this->Consumables->find('all');
        $this->assertEquals(2,$query->count());

        $activity = $this->Consumables->get(2);
        $this->assertEquals("Consumable Novo",$activity->nome);

    }
    
}
