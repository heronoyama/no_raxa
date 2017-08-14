<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Utils\UserRegistration;
use Cake\Mailer\MailerAwareTrait;

class UsersController extends AppController {
    use MailerAwareTrait;    

    public $helpers = ['Login'];

    public function initialize(){
        parent::initialize();
        $this->Auth->allow(['login','logout','add','index','delete','activate','reset','requestNewPassword']);
        $this->viewBuilder()->setLayout('login');
    }

    public function index() {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    public function view($id = null) {
        $this->viewBuilder()->setLayout("default");
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }
    
    public function add() {
    
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user['active'] = false;
            if ($this->Users->save($user)) {
                $success = $this->_sendVerificationEmail($user);
                if($success){
                    $this->Flash->success(__("Usuário criado com sucesso! Por favor, verifique sua caixa de email para ativar seu cadastro."));
                    return $this->redirect(['action' => 'login']);
                }
            }

            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function requestNewPassword(){
        if($this->request->is('post')){
            $email = $this->request->getData()['email'];
            $user = $user = $this->Users->findByEmail($email)->first();
            if(empty($user)){
                $this->Flash->error(__("Email não encontra$userdo"));
                return;
            }
            $user->active = false;
            $this->Users->save($user);
            $success = $this->_sendResetPasswordEmail($user);
            if($success){
                $this->Flash->success(__("Solicitação feita com sucesso. Cheque seu email."));
                return $this->redirect(['action' => 'login']);
            }
        }
    }

    public function reset($activationToken = null){
        if(!isset($activationToken)){
            $this->Flash->error(__("Token não encontrado!"));
            return $this->redirect(['action'=>'login']);
        }
        if($this->request->is('post')){
            $this->loadModel("Tokens");
            $token = $this->Tokens->isValid($activationToken);
            if(!$token){
                $this->Flash->error(__("Token não encontrado!"));
                return $this->redirect(['action'=>'login']);
            }
            $senha = $this->request->getData()['password'];
            $user = $token->user;
            $user->password = $senha;
            $user->active = true;
            if(!$this->Users->save($user)){
                $this->Flash->error(__("Deui ruim!"));
                return $this->redirect(['action'=>'login']);
            }
            $this->Tokens->delete($token);
            $this->Flash->success(__("Senha resetada com sucesso!"));
            return $this->redirect(['action'=>'login']);
        }
                
    }

    public function activate($activationToken = null) {
        if(!isset($activationToken)){
            $this->Flash->error(__("Token não encontrado!"));
            return $this->redirect(['action'=>'login']);
        }
        $this->loadModel("Tokens");
        $token = $this->Tokens->isValid($activationToken);
        if(!$token){
            $this->Flash->error(__("Token não encontrado!"));
            return $this->redirect(['action'=>'login']);
        }
        $user = $token->user;

        $user->active = true;
        if(!$this->Users->save($user)){
            $this->Flash->error(__("Deui ruim!"));
            return $this->redirect(['action'=>'login']);
        }
        $this->Tokens->delete($token);
        $this->Flash->success(__("Usuário ativado com sucesso!"));
        return $this->redirect(['action'=>'login']);


    }

    public function edit($id = null) {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login() {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }
    
    public function logout() {
        $this->request->session()->delete("Evento.id");
        return $this->redirect($this->Auth->logout());
    }

    private function _sendVerificationEmail($user){
        $this->loadModel("Tokens");
        $data = ["users_id" => $user->id, "token" => $user->getToken()];
        $token = $this->Tokens->newEntity($data);
        if (!$this->Tokens->save($token)) {
            return false;
        }
        $this->getMailer("Token")->send('activate',[$token,$user]);
        return true;
    }

    private function _sendResetPasswordEmail($user){
        $this->loadModel("Tokens");
        $data = ["users_id" => $user->id, "token" => $user->getToken()];
        $token = $this->Tokens->newEntity($data);
        if (!$this->Tokens->save($token)) {
            return false;
        }
        $this->getMailer("Token")->send('resetPassword',[$token,$user]);
        return true;
    }
}