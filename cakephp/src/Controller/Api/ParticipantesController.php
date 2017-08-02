<?php

namespace App\Controller\Api;

use App\Controller\Api\ApiAppController as ApiController;

class ParticipantesController extends ApiController {
    
     public function add() {
        $participante= $this->Participantes->newEntity();
        
        if (!$this->request->is('post')) {
            return $this->responseWithMessage(400,"Método não permitido");
            
        }
        
        if(!$this->saveModel($participante)){
            return $this->response->responseWithMessage(400,json_encode($participante->errors()));
        }
        
        $this->set(compact('participante'));
        $this->set('_serialize', ['participante']);
    }
    
    
    function edit($id = null){
        $participante = $this->Participantes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->saveModel($participante);
        }

        $this->set('participante',$participante);
        $this->set('_serialize', ['participante']);
    }
    
     public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $participante = $this->Participantes->get($id);
        $success = $this->deleteModel($participante);
        
        $message = $success ? "Participante deletado com sucesso!" : "Algo deu errado.";
        $this->set('message',$message);
        $this->set('_serialize',['message']);
    }
    
    protected function controller() {
        return $this->Participantes;
    }


}