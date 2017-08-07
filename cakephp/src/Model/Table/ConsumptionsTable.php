<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ConsumptionsTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('consumptions');
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
        
        return $validator;
    }

    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['eventos_id'], 'Eventos'));
        $rules->add($rules->existsIn(['participantes_id'], 'Participantes'));
        $rules->add($rules->existsIn(['consumables_id'], 'Consumables'));
        $rules->add($rules->isUnique(['participantes_id','eventos_id','consumables_id'],'Consumo ja criado para esse participante e consumivel ness evento'));


        return $rules;
    }
    
    public function newConsumption($data){
        $entity = $this->newEntity();;
        return $this->patchEntity($entity, $data);
    }
    
    public function loadRelations($model){
        $this->loadInto($model,['Participantes','Consumables']);
        return $model;
    }
}