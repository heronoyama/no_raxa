<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConsumablesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class ConsumablesTableTest extends TestCase {

    public $Consumables;

    public $fixtures = [
        'app.consumables',
        'app.eventos'
    ];

    public function setUp() {
        parent::setUp();
        $config = TableRegistry::exists('Consumables') ? [] : ['className' => ConsumablesTable::class];
        $this->Consumables = TableRegistry::get('Consumables', $config);
    }

    public function tearDown() {
        unset($this->Consumables);

        parent::tearDown();
    }

    public function testValidationDefault() {
         $data = [
            'nome' => 'Teste',
            'eventos_id' => 'Teste'
        ];

        $consumable = $this->Consumables->newEntity($data);
        $this->assertEmpty($consumable->errors());
    }

    public function testValidationEdit() {
         $data = [
            'nome' => 'Novo Nome'
        ];

        $consumable = $this->Consumables->get(1);
        $this->assertEquals('Consumable Fixture',$consumable->nome);
        $consumable = $this->Consumables->patchEntity($consumable,$data);
        $this->assertEmpty($consumable->errors());
        $current = $this->Consumables->get(1);
        $this->assertEquals('Novo Nome',$consumable->nome);
    }

}
