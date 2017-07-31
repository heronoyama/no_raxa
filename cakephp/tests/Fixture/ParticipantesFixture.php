<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ParticipantesFixture extends TestFixture {

    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'nome' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'eventos_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'eventos_id' => ['type' => 'index', 'columns' => ['eventos_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'participantes_ibfk_1' => ['type' => 'foreign', 'columns' => ['eventos_id'], 'references' => ['eventos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    
    public $records = [
        [
            'id' => 1,
            'nome' => 'Participante Fixture',
            'created' => '2017-07-31 19:01:56',
            'eventos_id' => 1,
            'modified' => '2017-07-31 19:01:56'
        ],
    ];
}
