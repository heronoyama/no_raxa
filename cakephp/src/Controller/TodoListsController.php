<?php
namespace App\Controller;

use App\Controller\AppController;


/**
 * TodoLists Controller
 *
 * @property \App\Model\Table\TodoListsTable $TodoLists
 *
 * @method \App\Model\Entity\TodoList[] paginate($object = null, array $settings = [])
 */
class TodoListsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $todoLists = $this->paginate($this->TodoLists);

        $this->set(compact('todoLists'));
        $this->set('_serialize', ['todoLists']);
    }

    /**
     * View method
     *
     * @param string|null $id Todo List id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $todoList = $this->TodoLists->get($id, [
            'contain' => ['Activities']
        ]);

        $this->set('todoList', $todoList);
        $this->set('_serialize', ['todoList']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $todoList = $this->TodoLists->newEntity();
        if ($this->request->is('post')) {
            $todoList = $this->TodoLists->patchEntity($todoList, $this->request->getData());
            if ($this->TodoLists->save($todoList)) {
                $this->Flash->success(__('The todo list has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The todo list could not be saved. Please, try again.'));
        }
        $this->set(compact('todoList'));
        $this->set('_serialize', ['todoList']);
    }

    public function addActivity($id = null){
        $this->loadModel('Activities');
        $activity = $this->Activities->newEntity();
        if ($this->request->is('post')) {
            $activity = $this->Activities->patchEntity($activity, $this->request->getData());
            if ($this->Activities->save($activity)){
                $this->Flash->success(__('The activity has been saved.'));
                return $this->redirect(['action'=>'view',$id]);
            }
            $this->Flash->error(__('The activity could not be saved. Please, try again.'));
        }

        $this->redirect(['action'=>'view',$id]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Todo List id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $todoList = $this->TodoLists->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $todoList = $this->TodoLists->patchEntity($todoList, $this->request->getData());
            if ($this->TodoLists->save($todoList)) {
                $this->Flash->success(__('The todo list has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The todo list could not be saved. Please, try again.'));
        }
        $this->set(compact('todoList'));
        $this->set('_serialize', ['todoList']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Todo List id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $todoList = $this->TodoLists->get($id);
        if ($this->TodoLists->delete($todoList)) {
            $this->Flash->success(__('The todo list has been deleted.'));
        } else {
            $this->Flash->error(__('The todo list could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
