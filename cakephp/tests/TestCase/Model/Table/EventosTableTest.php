<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EventosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class EventosTableTest extends TestCase {

    public $Eventos;

    public $fixtures = [
        'app.eventos'
    ];

    public function setUp() {
        parent::setUp();
        $config = TableRegistry::exists('Eventos') ? [] : ['className' => EventosTable::class];
        $this->Eventos = TableRegistry::get('Eventos', $config);
    }

    public function tearDown() {
        unset($this->Eventos);

        parent::tearDown();
    }

    
    public function testValidationDefault_dadosMinimos() {
         $data = [
            'nome' => 'Teste',
            'data' => '2017-07-28 16:01:24'
        ];

        $evento = $this->Eventos->newEntity($data);
        $this->assertEmpty($evento->errors());
    }

    public function testValidationDefault_todosOsDados() {
         $data = [
            'nome' => 'Teste',
            'data' => '2017-07-28 16:01:24',
            'pessoas_previstas' =>5,
            'localizacao' => 'casa do carlão'
        ];

        $evento = $this->Eventos->newEntity($data);
        $this->assertEmpty($evento->errors());
    }

    public function testValidationEdit() {
         $data = [
            'nome' => 'Novo teste'
        ];

        $evento = $this->Eventos->get(1);
        $evento = $this->Eventos->patchEntity($evento,$data);
        $this->assertEmpty($evento->errors());
    }

}
