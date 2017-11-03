<?php
namespace App\Controller\Api;

use App\Controller\Api\ApiAppController as ApiController;

class SurveyAnswersController extends ApiController {

    public function initialize(){
        parent::initialize();
        $this->Auth->allow(['questions','register','answers']);
        $this->loadModel("SurveyRespostas");
        $this->loadModel("Surveys");
    }

    public function questions($id){
        if (!$this->request->is('get')) {
            $response = $this->response->withStatus(400)->withStringBody(json_encode(["message"=>"Método não permitido"]));
            return $response;
        }

        $survey = $this->Surveys->get($id,['contain'=>['Perguntas']]);
        $this->set(compact(['survey']));
        $this->set('_serialize',['survey']);
        
    }

    public function answers($id){
        if (!$this->request->is('get')) {
            $response = $this->response->withStatus(400)->withStringBody(json_encode(["message"=>"Método não permitido"]));
            return $response;
        }

        $respostas = $this->SurveyRespostas->fromUser($id,$this->Auth->user('id'));
        $this->set(compact(['respostas']));
        $this->set('_serialize',['respostas']);
    }

    public function register($id) {

        if (!$this->request->is('post')) {
            $response = $this->response->withStatus(400)->withStringBody(json_encode(["message"=>"Método não permitido"]));
            return $response;
        }

        $respostas = $this->request->getData()['Pergunta'];
        $idResposta = $this->SurveyRespostas->registerAswers($id,$this->Auth->user('id'),$respostas);
        
        $resposta = $this->SurveyRespostas->get($idResposta,['contain'=>'Respostas']);
        $this->set(compact(['resposta']));
        $this->set('_serialize', ['resposta']);
    }

}