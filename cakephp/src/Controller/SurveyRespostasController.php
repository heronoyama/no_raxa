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
        
        $respostas = $this->request->getData()['Pergunta'];
        $this->SurveyRespostas->registerAswers($id,$this->Auth->user('id'),$respostas);

        $this->redirect(['action'=>'answer',$id]);
    }

}