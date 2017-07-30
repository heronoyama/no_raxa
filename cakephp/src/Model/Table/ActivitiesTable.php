<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ActivitiesTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('activities');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('TodoLists', [
            'foreignKey' => 'todo_lists_id',
            'joinType' => 'INNER'
        ]);
    }

    public function validationDefault(Validator $validator) {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('nome', 'create','Uma atividade deve ter um nome.')
            ->notEmpty('nome','Uma atividade deve ter um nome.');

        $validator
            ->boolean('concluded');

        $validator
            ->requirePresence('todo_lists_id','created','Uma atividade deve estar associada à uma lista.')
            ->notEmpty('todo_lists_id','Uma atividade deve estar associada à uma lista.');

        return $validator;
    }

    
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['todo_lists_id'], 'TodoLists'));

        return $rules;
    }
}
