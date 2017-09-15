<?php
namespace App\Controller;

use App\Controller\AppController;


class EventosController extends AppController {

    public function isAuthorized($user) {
        if(!parent::isAuthorized($user))
            return false;
        
        $action = $this->request->getParam('action');
        if (in_array($action,['add','index'])){
            return true;
        }

        if (in_array($this->request->getParam('action'), ['view','delete'])) {
            if ($this->userOwnsEvento($user)) {
                return true;
            }
        }
        return false;
    }

    public function index() {

        $userId = $this->Auth->user('id');
        $eventos = $this->Eventos->ownedBy($userId);
        $quantidadeEventos = $eventos->count();
        $this->set(compact('eventos','quantidadeEventos'));
        $this->set('_serialize', ['eventos','quantidadeEventos']);
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
    }

    public function add() {
        $userId = $this->Auth->user('id');
        $evento = $this->Eventos->newEntity();
        if ($this->request->is('post')) {
            $evento->users_id = $userId;
            return $this->saveRedirect($evento,['action' => 'index']);
        }

        if($this->Eventos->ownedBy($userId)->count() > 0){
            $this->Flash->error("Você já atingiu a sua cota de eventos gratuitos.");
            return $this->redirect($this->request->referer());
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
