<?php
namespace App\Controller;

use App\Controller\AppController;

class GivenEventoController extends AppController {

    public function isAuthorized($user) {
        if(!parent::isAuthorized($user))
            return false;

        $action = $this->request->getParam('action');
        if (in_array($action, $this->getActionsAllowed())) {
            $evento = $this->request->getParam('pass.0');
            
            if ($evento->isOwnedBy($user['id'])) {
                return true;
            }
        }
        return false;
    }

    protected function getActionsAllowed(){
        return ['index','view'];
    }

    public function index($evento) {
        $this->set('evento',$evento);
        $this->set('_serialize', ['evento']);
    }

}