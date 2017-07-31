<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ParticipantesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class ParticipantesTableTest extends TestCase {

    public $Participantes;

    public $fixtures = [
        'app.participantes',
        'app.eventos',
        'app.consumables'
    ];
    
    public function setUp() {
        parent::setUp();
        $config = TableRegistry::exists('Participantes') ? [] : ['className' => ParticipantesTable::class];
        $this->Participantes = TableRegistry::get('Participantes', $config);
    }

    public function tearDown() {
        unset($this->Participantes);

        parent::tearDown();
    }

    public function testValidationDefault() {
         $data = [
            'nome' => 'Teste',
            'eventos_id' => 1
        ];

        $participante = $this->Participantes->newEntity($data);
        $this->assertEmpty($participante->errors());
    }

    public function testValidationEdit() {
         $data = [
            'nome' => 'Novo Nome'
        ];

        $participante = $this->Participantes->get(1);
        $this->assertEquals('Participante Fixture',$participante->nome);
        $participante = $this->Participantes->patchEntity($participante,$data);
        $this->assertEmpty($participante->errors());
        $current = $this->Participantes->get(1);
        $this->assertEquals('Novo Nome',$participante->nome);
    }
}
