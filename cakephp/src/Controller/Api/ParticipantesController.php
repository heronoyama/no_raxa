<?php

namespace App\Controller\Api;

use App\Controller\Api\ApiAppController as ParentController;

class ParticipantesController extends ParentController {
    
     public function add() {
        $participante= $this->Participantes->newEntity();
        
        if (!$this->request->is('post')) {
            $response = $this->response->withStatus(400)->withStringBody(json_encode(["message"=>"Método não permitido"]));
            return $response;
        }
        
        if(!$this->saveModel($participante)){
            $response = $this->response->withStatus(400)->withStringBody(json_encode($participante->errors()));
            return $response;
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