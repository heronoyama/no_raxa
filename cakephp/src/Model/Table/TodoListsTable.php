<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class TodoListsTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('todo_lists');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->hasMany('Activities',[
            'foreignKey' => 'todo_lists_id',
            'joinType' => 'INNER']);
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
}
