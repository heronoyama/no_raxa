<?php
namespace App\Controller;

use App\Controller\AppController;

class ParticipantesController extends AppController {

    public function index($evento) {
        
        $this->paginate = [
            'contain' => ['Eventos']
        ];
        $participantes = $this->paginate($this->Participantes->find('all')->where(['eventos_id' => $evento->id]));

        $this->set(compact('participantes'));
        $this->set('evento',$evento);
        $this->set('_serialize', ['participantes','evento']);
    }

    public function view($id = null,$evento = null) {
        $participante = $this->Participantes->get($id, [
            'contain' => ['Eventos']
        ]);

        $this->set('participante', $participante);
        $this->set('evento',$evento);
        $this->set('_serialize', ['participante','evento']);
    }

    public function add($evento = null) {
        $participante = $this->Participantes->newEntity();
        
        if ($this->request->is('post')){
            $this->saveRedirect($participante,['action' => 'index',$evento->id]);
        }
        $eventos = $this->Participantes->Eventos->find('list', ['limit' => 200]);
        $this->set(compact('participante', 'eventos'));
        $this->set('evento',$evento);
        $this->set('_serialize', ['participante','evento']);
    }

    public function edit($id = null,$evento =null) {
        $participante = $this->Participantes->get($id, [
            'contain' => []
        ]);
        
       if ($this->request->is(['patch', 'post', 'put'])) {
            $this->saveRedirect($participante,['action' => 'index',$evento->id]);
        }
        
        $this->set('evento',$evento);
        $this->set('participante',$participante);
        $this->set('_serialize', ['participante','evento']);
    }

    public function delete($id = null,$evento =null) {
        $this->request->allowMethod(['post', 'delete']);
        $participante = $this->Participantes->get($id);
        
        $this->deleteModelRedirect($participante,['action' => 'index',$evento->id]);
    }
    
    protected function controller() {
        return $this->Participantes;
    }
}
