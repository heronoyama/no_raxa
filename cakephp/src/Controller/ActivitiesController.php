<?php
namespace App\Controller;

use App\Controller\AppController;

class ActivitiesController extends AppController{

    public function index(){
        $this->paginate = [
            'contain' => ['TodoLists']
        ];
        $activities = $this->paginate($this->Activities);

        $this->set(compact('activities'));
        $this->set('_serialize', ['activities']);
    }

    public function view($id = null){
        $activity = $this->Activities->get($id, [
            'contain' => ['TodoLists']
        ]);

        $this->set('activity', $activity);
        $this->set('_serialize', ['activity']);
    }

    public function add(){
        $activity = $this->Activities->newEntity();
        if ($this->request->is('post')) {
            $activity = $this->Activities->patchEntity($activity, $this->getParsedData());
            if ($this->Activities->save($activity)) {
                if(!$this->request->is('json')){
                    $this->Flash->success(__('The activity has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
            }
            if(!$this->request->is('json'))
                $this->Flash->error(__('The activity could not be saved. Please, try again.'));
        }
        $todoLists = $this->Activities->TodoLists->find('list', ['limit' => 200]);
        $this->set(compact('activity', 'todoLists'));
        $this->set('_serialize', ['activity']);
    }

    public function edit($id = null){
        $activity = $this->Activities->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $activity = $this->Activities->patchEntity($activity, $this->getParsedData());
            if ($this->Activities->save($activity)) {
                if(!$this->request->is('json')){
                    $this->Flash->success(__('The activity has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
            }
            if(!$this->request->is('json'))
                $this->Flash->error(__('The activity could not be saved. Please, try again.'));
        }
        $todoLists = $this->Activities->TodoLists->find('list', ['limit' => 200]);
        $this->set(compact('activity', 'todoLists'));
        $this->set('_serialize', ['activity']);
    }

    public function delete($id = null){
        $this->request->allowMethod(['post', 'delete']);
        $activity = $this->Activities->get($id);
        if ($this->Activities->delete($activity)) {
            if(!$this->request->is('json'))
                $this->Flash->success(__('The activity has been deleted.'));
        } else {
            if(!$this->request->is('json'))
                $this->Flash->error(__('The activity could not be deleted. Please, try again.'));
        }

        if(!$this->request->is('json'))
            return $this->redirect(['action' => 'index']);
    }

    public function toggleStatus($id){
        $activity = $this->Activities->get($id);
        if ($this->request->is(['put'])) {
            $activity->toggleStatus();
            if($this->Activities->save($activity)){
                $message = 'Atualizado';
            } else {
                $message = 'Deu ruim!';
            }
        }

        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);

    }

}
