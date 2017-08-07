<?php

namespace App\Controller\Api;

use App\Controller\Api\ApiAppController as ParentController;
use App\Utils\BalancoFinalParticipante;
use App\Utils\DetalhamentoParticipante;
use App\Utils\DetalhamentoConsumivel;
use App\Utils\BalancoConsumiveis;

class DivisorDespesasController extends ParentController {

    public function balancoParticipantes($idEvento = null) {

        $balanco = new BalancoFinalParticipante($idEvento);
        $result = $balanco->getData();

        $this->set("result", $result);
        $this->set('_serialize', 'result');
    }

    public function detalhamentoParticipante($idEvento = null, $idParticipante = null) {

        $detalhamento = new DetalhamentoParticipante($idEvento, $idParticipante);
        $result = $detalhamento->getData();

        $this->set("result", $result);
        $this->set('_serialize', 'result');
    }

    public function detalhamentoConsumivel($idEvento = null, $idConsumivel = null) {

        $detalhamento = new DetalhamentoConsumivel($idEvento, $idConsumivel);
        $result = $detalhamento->getData();

        $this->set("result", $result);
        $this->set('_serialize', 'result');
    }

    public function balancoConsumiveis($idEvento = null) {
        $balanco = new BalancoConsumiveis($idEvento);
        $result = $balanco->getData();

        $this->set("result", $result);
        $this->set('_serialize', 'result');
    }

}
