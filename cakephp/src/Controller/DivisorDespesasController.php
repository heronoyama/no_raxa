<?php

namespace App\Controller;

use App\Controller\AppController;

class DivisorDespesasController extends AppController {

     public function index($evento) {
        $this->set('evento',$evento);
        $this->set('_serialize', ['evento']);
    }

}

