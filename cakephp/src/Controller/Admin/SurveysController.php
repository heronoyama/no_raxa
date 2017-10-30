<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AdminController as ParentController;

class SurveysController extends ParentController {

    public function initialize(){
        parent::initialize();

        $this->loadModel('Surveys');
    }

    public function index(){
        $surveys = $this->Surveys->find('all',['contain'=>['Perguntas']]);
        $this->set(compact('surveys'));
        $this->set("_serialize",['surveys']);
    }

    public function view($id){
        $survey = $this->Surveys->get($id,['contain'=>['Perguntas']]);
        $this->set(compact('survey'));
        $this->set("_serialize",['survey']);

    }

}