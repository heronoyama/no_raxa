<?php
namespace App\Controller;

use App\Controller\AppController;

class EventosController extends AppController {

    public function index() {
        $eventos = $this->paginate($this->Eventos);

        $this->set(compact('eventos'));
        $this->set('_serialize', ['eventos']);
    }

    public function view($id = null) {
        $evento = $this->Eventos->get($id, [
            'contain' => []
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

    protected function controller(){
        return $this->Eventos;
    }
}
