<?php
namespace App\Controller;

use App\Controller\AppController;

class ConsumptionsController extends AppController {

     public function index($evento) {
        $this->set('evento',$evento);
        $this->set('_serialize', ['evento']);
    }

    protected function controller(){
            return $this->Consumptions;
    }
}
