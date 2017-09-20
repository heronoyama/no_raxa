<?php
namespace App\Controller;

use App\Controller\AppController;

class SurveyRespostasController extends AppController {

    public function answer($id){
        $this->loadModel("Surveys");
        $survey = $this->Surveys->get($id,['contain'=>'Perguntas']);

        $this->set(compact('survey'));
        $this->set('_serialize', ['surveys']);
    }

    public function register($id){
        $this->log($this->request->getData(),'debug');
        $this->redirect(['action'=>'answer',$id]);
    }

}