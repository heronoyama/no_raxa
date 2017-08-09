<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Utils\BalancoConsumiveis;
use App\Utils\BalancoFinalParticipante;
use App\Utils\MatrizConsumo;
use App\Utils\MatrizColaboracao;


class DivisorDespesasController extends AppController {
    

    public function index($evento) {
        $this->set('evento', $evento);
        $this->set('_serialize', ['evento']);
    }

    public function valorPorRecursoAnalitico($idEvento = null) {
        $this->response->download('report.csv');
        $balanco = new BalancoConsumiveis($idEvento);
        $data = $balanco->getData();
        $_serialize = 'data';
        $_header = ['ID', 'Nome', 'Valor Investido','Valor por Participante'];
        $this->set(compact('data', '_serialize','_header'));
        $this->viewBuilder()->className('CsvView.Csv');
        return;
    }
    
    public function balancoFinalParticipantes($idEvento = null){
        
        $this->response->download('report.csv');
        $balanco = new BalancoFinalParticipante($idEvento);
        $data = $balanco->getData();
        
        $_serialize = 'data';
        $_header = $balanco->headers();
        $this->set(compact('data', '_serialize','_header'));
        $this->viewBuilder()->className('CsvView.Csv');
        return;
    }
    
    public function matrizConsumo($idEvento = null){
        $this->response->download('report.csv');
        $matriz = new MatrizConsumo($idEvento);
        $data = $matriz->getData();
        $_serialize = 'data';
        
        $_header = $matriz->headers();
        $this->set(compact('data', '_serialize','_header'));
        $this->viewBuilder()->className('CsvView.Csv');
        return;
    }
    
    public function matrizColaboracao($idEvento = null){
        $this->response->download('report.csv');
        $matriz = new MatrizColaboracao($idEvento);
        $data = $matriz->getData();
        $_serialize = 'data';
        
        $_header = $matriz->headers();
        $this->set(compact('data', '_serialize','_header'));
        $this->viewBuilder()->className('CsvView.Csv');
        return;
    }

}
