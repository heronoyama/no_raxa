<?php
namespace App\Mailer;

use Cake\Mailer\Mailer;
use Cake\Routing\Router;


class TokenMailer extends Mailer {

    static public $name = 'Token';
    
    public function activate($token,$user){
        $this->to($user->email)
            ->profile('default')
            ->emailFormat('html')
            ->template('verification','token')
            ->viewVars(['nome' => $user->username,
                        'link' => $this->getLink($token,$user)])
            ->subject("Verificação de email - No Raxa!");

    }

    private function getLink($token){
        $finalToken = $token->getFullToken();
        $link =  Router::url(
             [ 'controller' => 'Users',
                'action' => 'activate',
                'token'=> $finalToken],true);
        return $link;
    }
}