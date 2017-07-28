<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Error\Debugger;

class EventosController extends AppController {

    public function index() {
        $eventos = $this->paginate($this->Eventos);

        $this->set(compact('eventos'));
        $this->set('_serialize', ['eventos']);
    }

    public function view($id = null) {
        $evento = $this->Eventos->get($id, [
            'contain' => ['Consumables']
        ]);

        $this->set('evento', $evento);
        $this->set('_serialize', ['evento']);
    }

    public function add() {
        $evento = $this->Eventos->newEntity();
        if ($this->request->is('post')) {
            $this->save($evento,['action' => 'index']);
        }
        
        $this->set(compact('evento'));
        $this->set('_serialize', ['evento']);
    }

    public function edit($id = null) {
        $evento = $this->Eventos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->save($evento,['action' => 'index']);
        }
        $this->set(compact('evento'));
        $this->set('_serialize', ['evento']);
    }

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $evento = $this->Eventos->get($id);
        $this->deleteModel($evento,['action' => 'index']);
    }

    public function addConsumable($id = null){
        
        $this->loadModel('Consumables');
        $consumable = $this->Consumables->newEntity();
        
        if ($this->request->is('post')) {

            $this->log("TESTE",'debug');
            $this->log($this->request->getData(),'debug');
            $data = $this->getParsedData();
            $data['eventos_id'] = $id;
            $this->log($data,'debug');
            $this->saveGivenDataAndController($this->Consumables,$consumable,$data,['action'=>'view',$id]);
        }

        $this->set('consumable', $consumable);
        $this->set('_serialize', ['consumable']);
    }

    protected function controller(){
        return $this->Eventos;
    }
}
