<?php

namespace App\Controller\Api;

use App\Controller\Api\ApiAppController as ApiController;

class EventosController extends ApiController {
    
    public function view($id = null) {
        $result = $this->toInclude();
        
        if(!$result->success){
            return $this->responseWithMessage(400,$result->error);
        }
        
        $contain = $result->values;
        if(sizeof($contain) == 0){
            $contain = ['Participantes','Consumables','Collaborations'];
        }

        $evento = $this->Eventos->get($id, [
            'contain' => $contain
        ]);

        $this->set('evento', $evento);
        $this->set('_serialize', ['evento']);
    }
    
     function edit($id = null){
        $evento = $this->Eventos->get($id, [
            'contain' => []
        ]);
                
        if (!$this->request->is(['put'])) {
            $message = 'Método inválido';
            $this->set('message',$message);
            $this->set('_serialize',['message']);
            return;
        }
        $this->saveModel($evento);
        $this->set('evento',$evento);
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
    
    public function addParticipante($id = null){
        
        $this->loadModel('Participantes');
        $participante = $this->Participantes->newEntity();
        
        if (!$this->request->is('post')){
            $message = "Método inválido";
            $this->set('message',$message);
            $this->set('_serialize',['message']);
            //TODO change code
            return;
        }
        
        $data = $this->getParsedData();
        $data['eventos_id'] = $id;

        $this->saveData($this->Participantes,$participante,$data);

        $this->set('consumable', $participante);
        $this->set('_serialize', ['consumable']);
    }
    
    protected function controller() {
        return $this->Eventos;
    }
}