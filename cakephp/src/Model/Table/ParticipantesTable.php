<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ParticipantesTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('participantes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Eventos', [
            'foreignKey' => 'eventos_id',
            'joinType' => 'INNER'
        ]);
        
        $this->hasMany('Collaborations',[
            'foreignKey' => 'participantes_id',
            'joinType' => 'INNER',
            'dependent' => true,
            'cascadeCallbacks'=>true]);
        
        $this->hasMany('Consumptions',[
            'foreignKey' => 'participantes_id',
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

        return $validator;
    }

    public function buildRules(RulesChecker $rules){
        $rules->add($rules->existsIn(['eventos_id'], 'Eventos'));

        return $rules;
    }
    
    public function all($idEvento){
        return $this->find('all',['contain'=>['Eventos']])->where([$this->alias().'.eventos_id' => $idEvento]);
    }
    
    public function getWithEvento($id){
        return $this->get($id, ['contain' => ['Eventos']]);
    }
}
