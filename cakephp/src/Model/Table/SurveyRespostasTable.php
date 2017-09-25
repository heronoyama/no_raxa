<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class SurveyRespostasTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('survey_respostas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Surveys', [
            'foreignKey' => 'surveys_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'users_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Respostas',[
            'foreignKey' => 'survey_respostas_id',
            'joinType' => 'INNER',
            'dependent' => true,
            'cascadeCallbacks'=>true]);
    }

    public function validationDefault(Validator $validator) {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        return $validator;
    }

    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['surveys_id'], 'Surveys'));
        $rules->add($rules->existsIn(['users_id'], 'Users'));

        return $rules;
    }
    
    public function alreadyAnswered($idSurvey, $userId){
        return $this->exists(['surveys_id' => $idSurvey, 'users_id'=>$userId]);
    }

    public function registerAswers($surveyId,$userId,$respostas){
        $surveyResposta = $this->newEntity();
        $surveyResposta['surveys_id'] = $surveyId;
        $surveyResposta['users_id'] = $userId;
        $this->save($surveyResposta);

        $respostaTable = TableRegistry::get('Respostas', []);

        foreach($respostas as $idPergunta => $answer){
            $resposta = $respostaTable->newEntity([
                'perguntas_id' => $idPergunta,
                'resposta' => $answer,
                'survey_respostas_id' => $surveyResposta->id

            ]);
            $respostaTable->save($resposta);
        }

        return $surveyResposta->id;

    }
}
