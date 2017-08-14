<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Utility\Security;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;

class FacebookLoginController extends AppController {
    
    //TODO make it work
    public $autoRender = false;
    public $layout = false;
    // O APP ID que você obteve ao registrar o Facebook App
    private $appID = '110100936356813';
    // Screcet Key que você obeve ao regitrar o Facebook App
    private $appSecret = '0bab1ee7df98f0549cb703a8c79f6f11';
	private $facebook;

    public function initialize() {
	    parent::initialize();
		$this->request->session()->start();
        $this->facebook = new Facebook([
                'app_id' => $this->appID,
	            'app_secret' => $this->appSecret,
	            'default_graph_version' => 'v2.10',
                ]);
		$this->Auth->allow(['auth', 'callback']);
	}

    public function auth() {
        
		$helper = $this->facebook->getRedirectLoginHelper();
	    $permissions = ['email'];
        $loginUrl = $helper->getLoginUrl(
			Router::url(['action' => 'callback'], true),
			$permissions
		);
        
        $this->redirect($loginUrl);
	}

    public function callback(){

        $helper = $this->facebook->getRedirectLoginHelper();
        try{
            $accessToken = $helper->getAccessToken();

            $response = $this->facebook->get('/me?fields=id,name, first_name,last_name, email', $accessToken);
            $fb_user = $response->getGraphUser();
            $this->loadModel('Users');
            $user = $this->Users->findByEmail($fb_user['email'])->first();
            if(empty($user)) {
			    //Vamos aleatoriamente gerar uma senha para este usuário.
                //Você pode implementar uma função que envie esta senha por E-mail.
                $password = Security::hash(time(), 'sha1', true);
                $data = [
                    'email' => $fb_user['email'],
                    'password' => $password,
                    'nome' => $fb_user['first_name'].' '.$fb_user['last_name']
                ];
                $user = $this->Users->newEntity($data);
                $this->Users->save($user);
                $this->Auth->setUser($data);
                unset($data['password']);
                $this->redirect($this->Auth->redirectUrl());
            }else{
                $data = [
                    'email' => $fb_user['email'],
                    'fname' => $fb_user['first_name']
                ];
            }
            $this->Auth->setUser($data);
            $this->request->session()->delete('Auth.User.password');
            $this->redirect($this->Auth->redirectUrl());
        }catch (FacebookSDKException $e) {
            throw new FacebookSDKException( sprintf('No access Token: %s',$e->getMessage()) );
        }
	}

    public function logout(){

    }
    
}