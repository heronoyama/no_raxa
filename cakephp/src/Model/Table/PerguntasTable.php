<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class PerguntasTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('perguntas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

         $this->belongsTo('Surveys', [
            'foreignKey' => 'surveys_id',
            'joinType' => 'INNER'
        ]);
    }

    public function validationDefault(Validator $validator) {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('pergunta', 'create')
            ->notEmpty('pergunta');

        $validator
            ->requirePresence('tipoResposta', 'create')
            ->notEmpty('tipoResposta');

        return $validator;
    }
}
