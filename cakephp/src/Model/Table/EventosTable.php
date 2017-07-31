<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class EventosTable extends Table {

    
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('eventos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Consumables',[
            'foreignKey' => 'eventos_id',
            'joinType' => 'INNER',
            'dependent' => true,
            'cascadeCallbacks'=>true]);
        
        $this->hasMany('Participantes',[
            'foreignKey' => 'eventos_id',
            'joinType' => 'INNER',
            'dependent' => true,
            'cascadeCallbacks'=>true]);
        
        $this->hasMany('Collaborations',[
            'foreignKey' => 'eventos_id',
            'joinType' => 'INNER',
            'dependent' => true,
            'cascadeCallbacks'=>true]);
    }

    public function validationDefault(Validator $validator) {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('nome', 'create')
            ->notEmpty('nome');

        $validator
            ->dateTime('data')
            ->requirePresence('data', 'create')
            ->notEmpty('data');

        $validator
            ->allowEmpty('localizacao');

        $validator
            ->integer('pessoas_previstas')
            ->allowEmpty('pessoas_previstas');

        return $validator;
    }
}
