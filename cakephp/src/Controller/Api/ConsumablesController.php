<?php

namespace App\Controller\Api;

use App\Controller\Api\ApiAppController as ParentController;

class ConsumablesController extends ParentController {

      public function index($idEvento = null){
        $where = ['eventos_id' => $idEvento];

        $consumables = $this->Consumables
                    ->find('all')
                    ->where($where);

        $this->set(compact('consumables'));
        $this->set('_serialize', ['consumables']);
    }
    
    public function add() {
        $consumable = $this->Consumables->newEntity();
        
        if (!$this->request->is('post')) {
            $response = $this->response->withStatus(400)->withStringBody(json_encode(["message"=>"Método não permitido"]));
            return $response;
        }
        
        if(!$this->saveModel($consumable)){
            $response = $this->response->withStatus(400)->withStringBody(json_encode($consumable->errors()));
            return $response;
        }
        
        $this->set(compact('consumable'));
        $this->set('_serialize', ['consumable']);
    }
    
    public function edit($id = null){
        $consumable = $this->Consumables->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->saveModel($consumable);
        }

        $this->set('consumable',$consumable);
        $this->set('_serialize', ['consumable']);
    }
    
     public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $consumable = $this->Consumables->get($id);
        $success = $this->deleteModel($consumable);
        
        $message = $success ? "Consumível deletado com sucesso!" : "Algo deu errado.";
        $this->set('message',$message);
        $this->set('_serialize',['message']);
    }
    
    protected function controller() {
        return $this->Consumables;
    }


}