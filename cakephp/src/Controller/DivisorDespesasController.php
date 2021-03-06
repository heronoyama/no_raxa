<?php

namespace App\Controller;

use App\Controller\GivenEventoController;
use App\Utils\BalancoConsumiveis;
use App\Utils\BalancoFinalParticipante;
use App\Utils\MatrizConsumo;
use App\Utils\MatrizColaboracao;


class DivisorDespesasController extends GivenEventoController {

    protected function getActionsAllowed(){
        return ['index','view','valorPorRecursoAnalitico','balancoFinalParticipantes','matrizConsumo','matrizColaboracao'];
    }
    
    public function index($evento) {
        $this->set('evento', $evento);
        $this->set('_serialize', ['evento']);
    }

    public function valorPorRecursoAnalitico($evento = null) {
        $this->response->download('report.csv');
        $balanco = new BalancoConsumiveis($evento->id);
        $data = $balanco->getData();
        $_serialize = 'data';
        $_header = ['ID', 'Nome', 'Valor Investido','Valor por Participante'];
        $this->set(compact('data', '_serialize','_header'));
        $this->viewBuilder()->className('CsvView.Csv');
        return;
    }
    
    public function balancoFinalParticipantes($evento = null){
        
        $this->response->download('report.csv');
        $balanco = new BalancoFinalParticipante($evento->id);
        $data = $balanco->getData();
        
        $_serialize = 'data';
        $_header = $balanco->headers();
        $this->set(compact('data', '_serialize','_header'));
        $this->viewBuilder()->className('CsvView.Csv');
        return;
    }
    
    public function matrizConsumo($evento = null){
        $this->response->download('report.csv');
        $matriz = new MatrizConsumo($evento->id);
        $data = $matriz->getData();
        $_serialize = 'data';
        
        $_header = $matriz->headers();
        $this->set(compact('data', '_serialize','_header'));
        $this->viewBuilder()->className('CsvView.Csv');
        return;
    }
    
    public function matrizColaboracao($evento = null){
        $this->response->download('report.csv');
        $matriz = new MatrizColaboracao($evento->id);
        $data = $matriz->getData();
        $_serialize = 'data';
        
        $_header = $matriz->headers();
        $this->set(compact('data', '_serialize','_header'));
        $this->viewBuilder()->className('CsvView.Csv');
        return;
    }

}
