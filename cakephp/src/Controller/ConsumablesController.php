<?php
namespace App\Controller;

use App\Controller\AppController;

class ConsumablesController extends AppController {

    public function index() {
        $this->paginate = [
            'contain' => ['Eventos']
        ];
        $consumables = $this->paginate($this->Consumables);

        $this->set(compact('consumables'));
        $this->set('_serialize', ['consumables']);
    }

    public function view($id = null) {
        $consumable = $this->Consumables->get($id, [
            'contain' => ['Eventos']
        ]);

        $this->set('consumable', $consumable);
        $this->set('_serialize', ['consumable']);
    }

    public function add() {
        $consumable = $this->Consumables->newEntity();
        if ($this->request->is('post')) {
            $this->save($consumable,['action' => 'index']);
        }

        $eventos = $this->Consumables->Eventos->find('list', ['limit' => 200]);
        $this->set(compact('consumable', 'eventos'));
        $this->set('_serialize', ['consumable']);
    }

    public function edit($id = null) {
        $consumable = $this->Consumables->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->save($consumable,['action' => 'index']);
        }

        $eventos = $this->Consumables->Eventos->find('list', ['limit' => 200]);
        $this->set(compact('consumable', 'eventos'));
        $this->set('_serialize', ['consumable']);
    }

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $consumable = $this->Consumables->get($id);
        $this->deleteModel($consumable,['action' => 'index']);
    }

    protected function controller(){
        return $this->Consumables;
    }
}
