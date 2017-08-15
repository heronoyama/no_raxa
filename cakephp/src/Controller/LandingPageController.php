<?php

namespace App\Controller;

use App\Form\ContactForm;

class LandingPageController extends AppController{

     public function initialize() {
         parent::initialize();
         $this->Auth->allow(['home','contact']);
     }

    public function isAuthorized($user) {
        return true;
    }

    public function home(){
        
    }

    public function contact(){
        $contact = new ContactForm();
        if ($this->request->is('post')) {
            if ($contact->execute($this->request->data)) {
                    $this->Flash->success('Sua mensagem foi enviada com sucesso! entraremos em contato logo =)!');
                    $this->request->data['email'] = null;
                    $this->request->data['body'] = null;
            } else {
                $this->log($contact->errors(),'debug');

                $this->Flash->error('Ops, algo de errado aconteceu :(');
            }
        }
        $this->redirect(['action'=>'home']);

    }
}