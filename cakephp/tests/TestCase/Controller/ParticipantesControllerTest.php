<?php
namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;
use App\Model\Table\EventosTable;
use App\Model\Table\ParticipantesTable;
use Cake\ORM\TableRegistry;

class ParticipantesControllerTest extends IntegrationTestCase {

    public $fixtures = [
        'app.participantes',
        'app.eventos',
        'app.consumables'
    ];
    
    public function setUp() {
        parent::setUp();
        $this->Eventos = TableRegistry::get('Eventos', ['className' => EventosTable::class]);
        $this->Participantes = TableRegistry::get('Participantes', ['className' => ParticipantesTable::class]);
    }

    public function testIndex_html() {
        $this->get('/eventos/1/participantes');
        $this->assertResponseOK();
        $this->assertResponseContains('<h3 data-id=1> Evento Teste Fixture (1) > Participantes</h3>');
        $this->assertResponseContains('<b data-bind="visible: !editing(), text: nome, click: edit">&nbsp;</b>');
        
        //TODO essa página tem execução de js para preencher os consumíveis
        //Melhor testar com Selenium
    }

    public function testView_html() {
        $this->get('/eventos/1/participantes/view/1');
        $this->assertResponseOK();
        $this->assertResponseContains('<h3>Participante Fixture (1)</h3>');
    }

    public function testAdd_html() {
        $data = ['nome'=>'ParticipanteTeste','eventos_id'=> 1];

        $query = $this->Participantes->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(0, $query->count());

        $this->post('/eventos/1/participantes/add',$data);
        $this->assertResponseSuccess();

        $query = $this->Participantes->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(1, $query->count());
    }
    
    public function testAdd_json() {
        $data = ['nome'=>'ParticipanteTeste','eventos_id'=> 1];

        $query = $this->Participantes->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(0, $query->count());

        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
        $this->post('/api/participantes.json',json_encode($data));
        $this->assertResponseSuccess();

        $query = $this->Participantes->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(1, $query->count());
    }

    public function testEdit_html() {
        $data = ['nome'=>'Participante Edit'];

        $query = $this->Participantes->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(0, $query->count());

        $current = $this->Participantes->get(1);
        $this->assertEquals("Participante Fixture",$current->nome);

        $this->put('/eventos/1/participantes/edit/1',$data);
        $this->assertResponseSuccess();

        $query = $this->Participantes->find()->where(['nome' => $data['nome']]);
        $this->assertEquals(1, $query->count());
        $current = $this->Participantes->get(1);
        $this->assertEquals("Participante Edit",$current->nome);
    }

    public function testDelete_html() {
        $query = $this->Participantes->find()->where(['nome' => "Participante Fixture"]);
        $this->assertEquals(1, $query->count());

        $this->post('/eventos/1/participantes/delete/1');
        $this->assertResponseSuccess();

        $query = $this->Participantes->find()->where(['nome' => "Participante Fixture"]);
        $this->assertEquals(0, $query->count());
    }
    
     public function testEdit_json() {
        $query = $this->Participantes->find()->where(['nome' => 'Teste Edit']);
        $this->assertEquals(0, $query->count());

        $current = $this->Participantes->get(1);
        $this->assertEquals("Participante Fixture",$current->nome);

         $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
 
        $data = "{\"nome\":\"Teste Edit\"}";
        $this->put('/api/participantes/1.json',$data);
        $this->assertResponseSuccess();

        $query = $this->Participantes->find()->where(['nome' => 'Teste Edit']);
        $this->assertEquals(1, $query->count());
        $current = $this->Participantes->get(1);
        $this->assertEquals("Teste Edit",$current->nome);
    }
    
    public function testDelete_json() {
        $query = $this->Participantes->find()->where(['nome' => "Participante Fixture"]);
        $this->assertEquals(1, $query->count());

        $this->delete('/api/participantes/1.json');
        $this->assertResponseSuccess();

        $query = $this->Participantes->find()->where(['nome' => "Participante Fixture"]);
        $this->assertEquals(0, $query->count());
    }
}
