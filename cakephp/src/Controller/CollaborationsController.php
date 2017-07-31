<?php

namespace App\Controller;

use App\Controller\AppController;

class CollaborationsController extends AppController {
    
    public function index($evento) {

        $collaborations = $this->paginate($this->Collaborations->find('all')->where(['eventos_id' => $evento->id]));

        $this->set(compact('collaborations'));
        $this->set('evento',$evento);
        $this->set('_serialize', ['collaborations','evento']);
    }

    protected function controller(){
            return $this->Collaborations;
    }
    
}