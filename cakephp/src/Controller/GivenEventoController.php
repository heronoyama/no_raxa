<?php
namespace App\Controller;

use App\Controller\AppController;

class GivenEventoController extends AppController {

    public function isAuthorized($user) {
        $action = $this->request->getParam('action');
        if (in_array($action, ['index','view'])) {
            $evento = $this->request->getParam('pass.0');
            
            if ($evento->isOwnedBy($user['id'])) {
                return true;
            }
        }
        return parent::isAuthorized($user);
    }

    public function index($evento) {
        $this->set('evento',$evento);
        $this->set('_serialize', ['evento']);
    }

}