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
            $activity = $this->Activities->patchEntity($activity, $this->request->getData());
            if ($this->Activities->save($activity)) {
                $this->Flash->success(__('The activity has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
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
            $activity = $this->Activities->patchEntity($activity, $this->request->getData());
            if ($this->Activities->save($activity)) {
                $this->Flash->success(__('The activity has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
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
            $this->Flash->success(__('The activity has been deleted.'));
        } else {
            $this->Flash->error(__('The activity could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
