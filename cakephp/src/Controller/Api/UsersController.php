<?php

namespace App\Controller\Api;

use App\Controller\Api\ApiAppController as ApiController;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

class UsersController extends ApiController {

    public function initialize(){
        parent::initialize();
        $this->Auth->allow(['add', 'token']);
    }

    public function add() {
        $user = $this->Users->newEntity();
        if (!$this->request->is('post')) {
            return $this->responseWithMessage(400, "Método não permitido");
        }
        if (!$this->saveModel($user)) {
            return $this->responseWithMessage(400, json_encode($user->errors()));
        }

        $data = ['id' => $user->id,
                'token' => JWT::encode(
                            ['sub' =>$user->id,'exp' =>  time() + 604800 ],
                            Security::salt())];
        
        $this->set('data', $data);
        $this->set('_serialize',['data']);

    }

    public function token(){
        $user = $this->Auth->user();
        if (!$user) {
            $user = $this->Auth->identify();
            if(!$user)
                throw new UnauthorizedException('Invalid username or password');
        }
        $this->set([
            'success' => true,
            'data' => [
                'token' => JWT::encode([
                    'sub' => $user['id'],
                    'exp' =>  time() + 604800
                ],
                Security::salt())
            ],
            '_serialize' => ['success', 'data']
        ]);
    }

    public function controller(){
        return $this->Users;
    }

}