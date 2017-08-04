<?php
namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;
use App\Model\Table\CollaborationsTable;
use Cake\ORM\TableRegistry;


class CollaborationsControllerTest extends IntegrationTestCase {
    
    public $fixtures = [
        'app.eventos',
        'app.consumables',
        'app.participantes',
        'app.collaborations'
    ];

     public function setUp() {
        parent::setUp();
        $this->Collaborations = TableRegistry::get('Consumables', ['className' => CollaborationsTable::class]);
    }
    
    public function testIndex_html(){
        $this->get('/eventos/1/collaborations');
        $this->assertResponseOK();
        $this->assertResponseContains('<h3> Evento Teste Fixture (1) > Colaborações</h3>');
    }
    
//    public function testAdd_json() {
//        $data = ['eventos_id'=> 1,'participantes_id'=>1,'consumables_id'=>1,'value'=> 20];
//
//        $query = $this->Collaborations->find()->where(['participantes_id' => $data['participantes_id']]);
//        $this->assertEquals(0, $query->count());
//        
//        $this->configRequest([
//            'headers' => [
//                'Accept' => 'application/json',
//                'Content-Type' => 'application/json'
//            ]
//        ]);
//        
//        $this->post('/api/collaborations.json',json_encode($data));
//        $this->_assertStatus(200,308,$this->_getBodyAsString());
//
//        $query = $this->Collaborations->find()->where(['participantes_id' => $data['participantes_id']]);
//        $this->assertEquals(1, $query->count());
//    }
    
}