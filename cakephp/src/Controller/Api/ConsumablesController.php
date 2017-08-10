<?php

namespace App\Controller\Api;

use App\Controller\Api\ApiAppController as ParentController;

class ConsumablesController extends ParentController {

    public function isAuthorized($user) {

        if ($this->userOwnsEvento($user)) {
            return true;
        }

        return parent::isAuthorized($user);
    }

    protected function getEventoIdFromRequest(){
        //TODO im ugly but im happy because i work
        /* If a system is a city, my security is like a milicia :P
        */
        $action = $this->request->getParam('action');
        
        if (in_array($action,['index'])){
            //vou perguntar para papai se posso
            return parent::getEventoIdFromRequest();
        }

        if(in_array($action,['add','edit'])){
            //meu corpinho tem a resposta
              return (int)$this->request->getData()['eventos_id'];
        }

        //Só posso querer deletar
        $id = (int)$this->request->getParam('pass.0');
        $consumable = $this->Consumables->get($id,['contain'=>'Eventos']);
        return $consumable->evento->id;
    }
    
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