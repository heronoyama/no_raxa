<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
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
        
         $this->hasMany('Consumptions',[
            'foreignKey' => 'eventos_id',
            'joinType' => 'INNER',
            'dependent' => true,
            'cascadeCallbacks'=>true]);

        $this->belongsTo('Users', [
            'foreignKey' => 'users_id',
            'joinType' => 'INNER'
        ]);
        
    }

    public function isOwnedBy($eventosId, $userId) {
        return $this->exists(['id' => $eventosId, 'users_id' => $userId]);
    }

    public function ownedBy($userId){
        return $this->find('all')->where(['users_id'=>$userId]);
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

    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['users_id'], 'Users'));
        $rules->add($rules->isUnique(['users_id'],'Usuário já possui um evento cadastrado gratuitamente.'));


        return $rules;
    }
}
