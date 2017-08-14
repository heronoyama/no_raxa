<?php
namespace App\Controller;

use App\Controller\AppController;


class EventosController extends AppController {

    public function isAuthorized($user) {
        $action = $this->request->getParam('action');
        if (in_array($action,['add','index'])){
            return true;
        }

        if (in_array($this->request->getParam('action'), ['view','delete'])) {
            if ($this->userOwnsEvento($user)) {
                return true;
            }
        }
        return parent::isAuthorized($user);
    }

    public function index() {
        $eventos = $this->paginate($this->Eventos->ownedBy($this->Auth->user('id')));

        $this->set(compact('eventos'));
        $this->set('_serialize', ['eventos']);
        $this->Auth->identify();

        $this->request->session()->delete("Evento.id");
    }

    public function view($id = null) {
        $evento = $this->Eventos->get($id, [
            'contain' => ['Consumables','Participantes']
        ]);


    //TODO
        $this->set('evento', $evento);
        $this->set('consumables',$evento->consumables);
        $this->set('participantes',$evento->participantes);
        $this->set('_serialize', ['evento','consumables','participantes']);

        $this->request->session()->write("Evento.id",$id);
    }

    public function add() {
        $evento = $this->Eventos->newEntity();
        if ($this->request->is('post')) {
            $evento->users_id = $this->Auth->user('id');
            $this->saveRedirect($evento,['action' => 'index']);
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
