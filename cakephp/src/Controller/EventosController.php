<?php
namespace App\Controller;

use App\Controller\AppController;


class EventosController extends AppController {

    public function index() {
        $eventos = $this->paginate($this->Eventos);

        $this->set(compact('eventos'));
        $this->set('_serialize', ['eventos']);
        $this->request->session()->delete("Evento.id");
    }

    public function view($id = null) {
        $evento = $this->Eventos->get($id, [
            'contain' => ['Consumables','Participantes']
        ]);

        $this->set('evento', $evento);
        $this->set('consumables',$evento->consumables);
        $this->set('participantes',$evento->participantes);
        $this->set('_serialize', ['evento','consumables','participantes']);

        $this->request->session()->write("Evento.id",$id);
    }

    public function add() {
        $evento = $this->Eventos->newEntity();
        if ($this->request->is('post')) {
            $this->saveRedirect($evento,['action' => 'index']);
        }
        
        $this->set(compact('evento'));
        $this->set('_serialize', ['evento']);
    }

    public function edit($id = null) {
        $evento = $this->Eventos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->saveRedirect($evento,['action' => 'view',$id]);
        }
        $this->set(compact('evento'));
        $this->set('_serialize', ['evento']);
    }

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $evento = $this->Eventos->get($id);
        $this->deleteModelRedirect($evento,['action' => 'index']);
    }

    protected function controller(){
        return $this->Eventos;
    }
}
