<?php
namespace App\Controller\Api;
use Cake\Controller\Controller;
use Cake\Event\Event;

class AppController extends Controller{

     public function initialize() {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
    }

}