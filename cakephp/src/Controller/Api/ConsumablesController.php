<?php

namespace App\Controller\Api;

use App\Controller\Api\ApiAppController as ParentController;

class ConsumablesController extends ParentController {
    
    function edit($id = null){
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