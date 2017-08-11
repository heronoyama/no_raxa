<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Log\LogTrait;

class TokensTable extends Table {
    use LogTrait;

    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('tokens');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'users_id',
            'joinType' => 'INNER'
        ]);
    }

    public function validationDefault(Validator $validator) {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('token', 'create')
            ->notEmpty('token');

        return $validator;
    }

    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['users_id'], 'Users'));

        return $rules;
    }

    public function isValid($activationToken){
        list($userToken, $currentToken) = explode("-",$activationToken);
        $token = $this->find('all',['contain'=>['Users']])->where(['token'=>$userToken])->first();
        if(!isset($token))
            return null;

        return $token;
    }
}