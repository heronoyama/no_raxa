<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AdminController as ParentController;

class SurveyAnswersController extends ParentController {

    public function initialize(){
        parent::initialize();

        $this->loadModel('SurveyRespostas');
    }

    public function index(){
        $surveys = $this->SurveyRespostas->find('all',['contain'=>['Users','Surveys']]);
        $this->set(compact('surveys'));
        $this->set("_serialize",['surveys']);
    }

    public function view($id){
        $survey = $this->SurveyRespostas->get($id,['contain'=>['Users','Surveys','Respostas','Respostas.Perguntas']]);
        $this->set(compact('survey'));
        $this->set("_serialize",['survey']);

    }

}