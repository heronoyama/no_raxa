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

    protected function getParsedData() {
        return $this->request->getData();
    }
    
    protected function saveModel($model) {
        return $this->saveData($this->controller(), $model, $this->getParsedData());
    }

    protected function saveData($controller, $model, $data) {
        $model = $controller->patchEntity($model, $data);
        return $controller->save($model);
    }

    protected function deleteModel($model) {
        return $this->controller()->delete($model);
    }

    protected function saveRedirect($model, $destiny) {
        $this->saveDataRedirect($this->controller(), $model, $this->getParsedData(), $destiny);
    }

    protected function saveDataRedirect($controller, $model, $data, $destiny) {
        if ($this->saveData($controller, $model, $data)) {
            $this->flashSucess();
            return $this->redirect($destiny);
        }
        $this->flashError();
    }

    protected function deleteModelRedirect($model, $destiny) {
        $success = $this->deleteModel($model);
        if ($this->request->is('json'))
            return;

        if ($success)
            $this->flashSucess();
        else
            $this->flashError();
        return $this->redirect($destiny);
    }

    private function flashSucess() {
        $this->Flash->success(__('Operação realizada com sucesso'));
    }

    private function flashError() {
        $this->Flash->error(__("Oops, algo deu errado. Por favor, tente novamente."));
    }

    protected function controller() {
        return null;
    }

}
