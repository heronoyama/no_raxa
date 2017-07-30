<?php
namespace App\Controller;

use App\Controller\AppController;

class ConsumablesController extends AppController {

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

    public function add($evento = null) {
        $consumable = $this->Consumables->newEntity();
        if ($this->request->is('post')) {
            $this->saveRedirect($consumable,['action' => 'index',$evento->id]);
        }

        $eventos = $this->Consumables->Eventos->find('list', ['limit' => 200]);
        $this->set(compact('consumable', 'eventos'));
        $this->set('evento',$evento);
        $this->set('_serialize', ['consumable','evento']);
    }

    public function edit($id = null,$evento =null) {
        $consumable = $this->Consumables->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->saveRedirect($consumable,['action' => 'index',$evento->id]);
        }

        $this->set('evento',$evento);
        $this->set('consumable',$consumable);
        $this->set('_serialize', ['consumable','evento']);
    }

    public function delete($id = null,$evento =null) {
        $this->request->allowMethod(['post', 'delete']);
        $consumable = $this->Consumables->get($id);
        $this->deleteModelRedirect($consumable,['action' => 'index',$evento->id]);
    }

    protected function controller(){
        return $this->Consumables;
    }

     private function getConsumables($eventoId){
        return  $this->Consumables->find('all')->where(['eventos_id' => $eventoId]);
    }
}