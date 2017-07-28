<?php
namespace App\Controller;

use App\Controller\AppController;

class EventosController extends AppController
{

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
            // print_r($this->getParsedData());
            $evento = $this->Eventos->patchEntity($evento, $this->getParsedData());
            if ($this->Eventos->save($evento)) {
                if(!$this->request->is('json')){
                    $this->Flash->success(__('The evento has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
            }
            if(!$this->request->is('json'))
                $this->Flash->error(__('The evento could not be saved. Please, try again.'));
        }

        $this->set(compact('evento'));
        $this->set('_serialize', ['evento']);
    }

    public function edit($id = null) {
        $evento = $this->Eventos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $evento = $this->Eventos->patchEntity($evento, $this->getParsedData());
            if ($this->Eventos->save($evento)) {
                if(!$this->request->is('json')){
                    $this->Flash->success(__('The evento has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
            }
            if(!$this->request->is('json'))
                $this->Flash->error(__('The evento could not be saved. Please, try again.'));
        }
        $this->set(compact('evento'));
        $this->set('_serialize', ['evento']);
    }

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $evento = $this->Eventos->get($id);
        if ($this->Eventos->delete($evento)) {
            if(!$this->request->is('json'))
                $this->Flash->success(__('The evento has been deleted.'));
        } else {
            if(!$this->request->is('json'))
                $this->Flash->error(__('The evento could not be deleted. Please, try again.'));
        }
        if(!$this->request->is('json'))
            return $this->redirect(['action' => 'index']);
    }
}
