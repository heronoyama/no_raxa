<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CollaborationsFixture
 *
 */
class CollaborationsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'value' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'eventos_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'participantes_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'consumables_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'eventos_id' => ['type' => 'index', 'columns' => ['eventos_id'], 'length' => []],
            'participantes_id' => ['type' => 'index', 'columns' => ['participantes_id'], 'length' => []],
            'consumables_id' => ['type' => 'index', 'columns' => ['consumables_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'collaborations_ibfk_1' => ['type' => 'foreign', 'columns' => ['eventos_id'], 'references' => ['eventos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'collaborations_ibfk_2' => ['type' => 'foreign', 'columns' => ['participantes_id'], 'references' => ['participantes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'collaborations_ibfk_3' => ['type' => 'foreign', 'columns' => ['consumables_id'], 'references' => ['consumables', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'value' => 1,
            'eventos_id' => 1,
            'participantes_id' => 1,
            'consumables_id' => 1,
            'created' => '2017-07-31 21:14:54',
            'modified' => '2017-07-31 21:14:54'
        ],
    ];
}
