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
            ->viewVars(['nome' => $user->nome,
                        'link' => $this->getLinkActivation($token,$user)])
            ->subject("Verificação de email - No Raxa!");

    }

    public function resetPassword($token,$user){
        $this->to($user->email)
            ->profile('default')
            ->emailFormat('html')
            ->template('reset','token')
            ->viewVars(['link' => $this->getLinkActivation($token,$user)])
            ->subject("Reset de senha - No Raxa!");
    }

    private function getLinkActivation($token){
        $finalToken = $token->getFullToken();
        $link =  Router::url(
             [ 'controller' => 'Users',
                'action' => 'reset',
                'token'=> $finalToken],true);
        return $link;
    }
}