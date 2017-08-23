<?php

namespace App\Controller;

use App\Controller\GivenEventoController;
use App\Utils\BalancoConsumiveis;
use App\Utils\BalancoFinalParticipante;
use App\Utils\MatrizConsumo;
use App\Utils\MatrizColaboracao;


class DashboardController extends GivenEventoController {

    public function index($evento) {
        $this->set('evento', $evento);
        $this->set('_serialize', ['evento']);

        $this->request->session()->write("Evento.id",$evento->id);
    }

}
