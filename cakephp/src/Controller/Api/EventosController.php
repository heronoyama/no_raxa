<?php

namespace App\Controller\Api;

use App\Controller\Api\ApiAppController as ParentController;

class EventosController extends ParentController {
    
    public function view($id = null) {
        $evento = $this->Eventos->get($id, [
            'contain' => ['Consumables']
        ]);

        $this->set('evento', $evento);
        $this->set('_serialize', ['evento']);
    }
    
    public function addConsumable($id = null){
        
        $this->loadModel('Consumables');
        $consumable = $this->Consumables->newEntity();
        
        if (!$this->request->is('post')){
            $message = "Método inválido";
            $this->set('message',$message);
            $this->set('_serialize',['message']);
            //TODO change code
            return;
        }
        
        $data = $this->getParsedData();
        $data['eventos_id'] = $id;

        $this->saveData($this->Consumables,$consumable,$data);

        $this->set('consumable', $consumable);
        $this->set('_serialize', ['consumable']);
    }
    
    protected function controller() {
        return $this->Eventos;
    }
}