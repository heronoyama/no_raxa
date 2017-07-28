<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ConsumablesTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('consumables');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Eventos', [
            'foreignKey' => 'eventos_id',
            'joinType' => 'INNER'
        ]);
    }

    public function validationDefault(Validator $validator) {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('nome', 'create')
            ->notEmpty('nome');

        return $validator;
    }

    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['eventos_id'], 'Eventos'));

        return $rules;
    }
}
