<?php
namespace App\Controller;

use App\Controller\AppController;

class SurveyRespostasController extends AppController {

    public function answer($id){
        $this->loadModel("Surveys");
        $survey = $this->Surveys->get($id,['contain'=>'Perguntas']);

        if($this->SurveyRespostas->alreadyAnswered($id,$this->Auth->user('id')))
            $this->Flash->error("Usuário já respondeu esse survey!");

        $this->set(compact('survey'));
        $this->set('_serialize', ['surveys']);
    }

    public function register($id){
        
        //TODO => Passar para uma outra classe
        $respostas = $this->request->getData()['Pergunta'];
        $this->log($respostas,'debug');
        $this->loadModel('Perguntas');
        $this->loadModel('SurveyRespostas');
        $this->loadModel('Respostas');

        $surveyResposta = $this->SurveyRespostas->newEntity();
        $surveyResposta['surveys_id'] = $id;
        $surveyResposta['users_id'] = $this->Auth->user('id');
        $this->SurveyRespostas->save($surveyResposta);

        foreach($respostas as $idPergunta => $answer){
            $pergunta = $this->Perguntas->get($idPergunta);
            $resposta = $this->Respostas->newEntity([
                'perguntas_id' => $pergunta->id,
                'resposta' => $answer,
                'survey_respostas_id' => $surveyResposta->id

            ]);
            $this->Respostas->save($resposta);
            
        }
        $this->redirect(['action'=>'answer',$id]);
    }

}