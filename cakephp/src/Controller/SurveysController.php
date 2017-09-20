<?php
namespace App\Controller;

use App\Controller\AppController;

class SurveysController extends AppController {

    public function index() {
        
        $surveys = $this->paginate($this->Surveys);

        $this->set(compact('surveys'));
        $this->set('_serialize', ['surveys']);
    }

    
    public function view($id = null) {
        $survey = $this->Surveys->get($id, [
            'contain' => ['Perguntas']
        ]);

        $this->set('survey', $survey);
        $this->set('_serialize', ['survey']);
    }

    public function add() {
        $survey = $this->Surveys->newEntity();
        if ($this->request->is('post')) {
            return $this->saveRedirect($survey,['action' => 'index']);
        }
        $this->set(compact('survey'));
        $this->set('_serialize', ['survey']);
    }

    public function edit($id = null) {
        $survey = $this->Surveys->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            return $this->saveRedirect($survey,['action' => 'index']);
        }
        $this->set(compact('survey'));
        $this->set('_serialize', ['survey']);
    }

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $survey = $this->Surveys->get($id);
        
        $this->deleteModelRedirect($survey,['action' => 'index']);
    }

    public function controller(){
        return $this->Surveys;
    }
}
