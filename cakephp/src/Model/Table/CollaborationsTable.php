<?php
namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CollaborationsTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('collaborations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Eventos', [
            'foreignKey' => 'eventos_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Participantes', [
            'foreignKey' => 'participantes_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Consumables', [
            'foreignKey' => 'consumables_id',
            'joinType' => 'INNER'
        ]);
    }

    public function validationDefault(Validator $validator) {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->numeric('value')
            ->requirePresence('value', 'create')
            ->notEmpty('value');

        return $validator;
    }

    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['eventos_id'], 'Eventos'));
        $rules->add($rules->existsIn(['participantes_id'], 'Participantes'));
        $rules->add($rules->existsIn(['consumables_id'], 'Consumables'));

        return $rules;
    }
}
