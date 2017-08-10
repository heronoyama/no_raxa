<?php

namespace App\Controller\Api;

use App\Controller\Api\ApiAppController as ApiController;

class EventosController extends ApiController {
    
    //TODO check use
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
    
    protected function controller() {
        return $this->Eventos;
    }
}