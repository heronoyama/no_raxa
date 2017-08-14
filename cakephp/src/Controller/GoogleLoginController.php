<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Utility\Security;
use Google_Service_Exception;
use Cake\Log\LogTrait;

class GoogleLoginController extends AppController {
    use LogTrait;

    public $layout = false;
        
    public $autoRender = false;
        
    private $google_client_id = '456542078446-qfnropfuq9o2ev3js1o1t2jickq965p2.apps.googleusercontent.com';
    private $google_client_secret = 'l0NJ4ojZI1wImjvGpDBOSSWD';
        
    private $google_api_key = 'no-raxa';

    public function initialize() {
		parent::initialize();
		$this->Auth->allow(['auth', 'callback']);
		$this->request->session()->start();
		
		//Google_Client
		$this->client = new \Google_Client();
		$this->client->setClientId($this->google_client_id);
		$this->client->setClientSecret($this->google_client_secret);
		$this->client->setRedirectUri(Router::url(['action' => 'callback'],true));
		$this->client->setDeveloperKey($this->google_api_key);
		$this->client->setScopes(['https://www.googleapis.com/auth/plus.me',
        'https://www.googleapis.com/auth/userinfo.email' ]);		
		$this->plus = new \Google_Service_Plus($this->client);

	}

    public function auth() {
        $authUrl = $this->client->createAuthUrl();
        $this->redirect($authUrl);
	}

    public function callback(){
        try {
            $this->client->authenticate($this->request->query['code']);
            if ($this->client->getAccessToken()) {
                $user = $this->plus->people->get('me');
                $nome = $user->getName()->givenName .' '. $user->getName()->familyName;
                $emails = $user->getEmails();
                $user_email = $emails[0]->value; 
                if( !empty( $user_email ) ) {
                    $this->loadModel('Users');
                    $password = Security::hash($user_email, 'sha1', true);
                    $user = $this->Users->findByEmail($user_email)->first();
                    if( empty( $user ) ) {
                        $data = [
                            'email' => $user_email,
                            'password' => $password,
                            'nome' => $nome,
                            'active' => true
                        ];
                        $user = $this->Users->newEntity($data);
                        $this->Users->save($user);
                        
                        unset($data['password']);
                        $this->Auth->setUser($data);
                        $this->request->session()->delete('Auth.User.password');
                        $this->redirect($this->Auth->redirectUrl());
                    }else{
                        $user = $user->toArray();
                        $data = ['id' => $user['id'],
				                'email' => $user['email'], 
                                'nome' => $user['nome'],
                                'active' => true];
                        $this->Auth->setUser($data);
                        $this->request->session()
						     ->delete('Auth.User.password');
                        $this->redirect($this->Auth->redirectUrl());
                    }
                }        
            }
        } catch(Google_Service_Exception $e){
            throw new Google_Service_Exception(sprintf('Error: %s',$e->getMessage()));
        }
    }


}
    