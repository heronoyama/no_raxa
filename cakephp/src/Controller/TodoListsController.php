<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Error\Debugger;

//TODO refatorar
class TodoListsController extends AppController{

    public function index()
    {
        $todoLists = $this->paginate($this->TodoLists);

        $this->set(compact('todoLists'));
        $this->set('_serialize', ['todoLists']);
    }

    public function view($id = null) {
        $todoList = $this->TodoLists->get($id, [
            'contain' => ['Activities']
        ]);

        $this->set('todoList', $todoList);
        $this->set('_serialize', ['todoList']);
    }

    public function add() {
       $todoList = $this->TodoLists->newEntity();
        if ($this->request->is('post')) {
            $todoList = $this->TodoLists->patchEntity($todoList,$this->getParsedData());
            if ($this->TodoLists->save($todoList)) {
                if(!$this->request->is('json')){
                    $this->Flash->success(__('The todo list has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
            if(!$this->request->is('json'))
               $this->Flash->error(__('The todo list could not be saved.
                Please, try again.'));
        }
        $this->set(compact('todoList'));
        $this->set('_serialize', ['todoList']);
    }

    

    public function addActivity($id = null){

        $this->loadModel('Activities');
        $activity = $this->Activities->newEntity();
        if ($this->request->is('post')) {
            $data = $this->getParsedData();
            $data['todo_lists_id'] = $id;
            $activity = $this->Activities->patchEntity($activity, $data);
            if ($this->Activities->save($activity)){
                if(!$this->request->is('json')){
                    $this->Flash->success(__('The activity has been saved.'));
                    return $this->redirect(['action'=>'view',$id]);
                }
            }
            if(!$this->request->is('json'))
                $this->Flash->error(__('The activity could not be saved. Please, try again.'));
        }

        if(!$this->request->is('json'))
            $this->redirect(['action'=>'view',$id]);
    }

    public function edit($id = null) {
        $todoList = $this->TodoLists->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $todoList = $this->TodoLists->patchEntity($todoList, $this->getParsedData());
            if ($this->TodoLists->save($todoList)) {
                if(!$this->request->is('json')){
                $this->Flash->success(__('The todo list has been saved.'));
                return $this->redirect(['action' => 'index']);
                }
            }
            if(!$this->request->is('json'))
                $this->Flash->error(__('The todo list could not be saved. Please, try again.'));
        }
        $this->set(compact('todoList'));
        $this->set('_serialize', ['todoList']);
    }

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $todoList = $this->TodoLists->get($id);
        if ($this->TodoLists->delete($todoList)) {
            if(!$this->request->is('json'))
                $this->Flash->success(__('The todo list has been deleted.'));
        } else {
            if(!$this->request->is('json'))
                $this->Flash->error(__('The todo list could not be deleted. Please, try again.'));
        }
        if(!$this->request->is('json'))
            return $this->redirect(['action' => 'index']);
    }
}