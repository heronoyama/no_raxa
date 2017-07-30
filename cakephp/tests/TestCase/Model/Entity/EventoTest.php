<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EventosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class EventosTest extends TestCase {

	public $Activities;

    public $fixtures = [
        'app.eventos',
        'app.consumables'
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

    public function testGetter(){
    	$evento = $this->Eventos->get(1,['contain' =>['Consumables']]);
        $this->assertEquals("Evento Teste Fixture",$evento->nome);

        $consumables = $evento->consumables;
        $this->assertEquals(1,sizeof($consumables));
        $this->assertEquals("Consumable Fixture",$consumables[0]->nome);
    }

    
}