<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

class AppController extends Controller {

    
    public function initialize() {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }

    
    public function beforeRender(Event $event) {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    protected function getParsedData(){
        if($this->request->is('json'))
            //The best i could manage
            return json_decode($this->request->getData()[0],true);
        
        return $this->request->getData();
    }

    protected function save($model,$destiny){
        $model = $this->controller()->patchEntity($model, $this->getParsedData());
        if ($this->controller()->save($model)) {
            if(!$this->request->is('json')){
                $this->flashSucess();
                return $this->redirect($destiny);
            }
        }

        if(!$this->request->is('json'))
            $this->flashError();
    }

    protected function deleteModel($model,$destiny){
        $sucess = $this->controller()->delete($model);
        if ($this->request->is('json'))
            return;
        
        if($sucess)    
            $this->flashSucess();
        else
            $this->flashError();
        
        return $this->redirect($destiny);
    }

    private function flashSucess(){
        $this->Flash->success(__('Operação realizada com sucesso'));
    }

    private function flashError(){
        $this->Flash->success(__("Oops, algo deu errado. Por favor, tente novamente."));   
    }

    protected function controller(){
        return null;
    }
}
