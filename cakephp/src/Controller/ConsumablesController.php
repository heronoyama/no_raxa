<?php
namespace App\Controller;

use App\Controller\AppController;

class ConsumablesController extends AppController {

     public function isAuthorized($user) {
        $this->log("Im verifiy if im authorized",'debug');
        $action = $this->request->getParam('action');
        if (in_array($action, ['view','index'])) {
            $evento = $this->request->getParam('pass.0');
            
            if ($evento->isOwnedBy($user['id'])) {
                return true;
            }
        }
        return parent::isAuthorized($user);
    }

    public function index($evento) {

        $this->paginate = [
            'contain' => ['Eventos']
        ];

        $consumables = $this->paginate($this->getConsumables($evento->id));

        $this->set(compact('consumables'));
        $this->set('evento',$evento);
        $this->set('_serialize', ['consumables','evento']);
    }

    public function view($id = null,$evento = null) {
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