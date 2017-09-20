<?php
namespace App\Controller;

use App\Controller\AppController;

class PerguntasController extends AppController {

    protected function getActionsAllowed(){
        return ['index','add'];
    }

    public function index() {
        $perguntas = $this->paginate($this->Perguntas->find('all',['contain'=>'Surveys']));

        $this->set(compact('perguntas'));
        $this->set('_serialize', ['perguntas']);
    }

    public function add(){
        $pergunta = $this->Perguntas->newEntity();
        
        if ($this->request->is('post')) {
            return $this->saveRedirect($pergunta,['action' => 'index']);
        }

        $surveys = $this->Perguntas->Surveys->find('list',[ 'keyField' => 'id', 'valueField' => 'nome']);
        $this->set(compact('pergunta','surveys'));
        $this->set('_serialize', ['pergunta','surveys']);
    }

    protected function controller(){
        return $this->Perguntas;
    }



}