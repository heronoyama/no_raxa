<?php
namespace App\Controller;

use App\Controller\GivenEventoController;

class ConsumablesController extends GivenEventoController {

    public function index($evento) {

        $this->paginate = [
            'contain' => ['Eventos']
        ];

        $consumables = $this->paginate($this->getConsumables($evento->id));

        $this->set(compact('consumables'));
        $this->set('evento',$evento);
        $this->set('_serialize', ['consumables','evento']);
    }

    public function view($evento = null,$id = null) {
        $consumable = $this->Consumables->get($id, [
            'contain' => ['Eventos']
        ]);

        $this->set('consumable', $consumable);
        $this->set('evento',$evento);
        $this->set('_serialize', ['consumable','evento']);
    }

    protected function controller(){
        return $this->Consumables;
    }

     private function getConsumables($eventoId){
        return  $this->Consumables->find('all')->where(['eventos_id' => $eventoId]);
    }
}