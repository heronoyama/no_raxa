<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

class LoginHelper extends Helper {

    
    protected $_defaultConfig = [];

    public $helpers = ['Url'];
    
    //TODO refatorar
    public function cssLogin(){
        if($this->request->getParam('action') == 'login')
            return 'class="loginAction active"';
        return 'class="loginAction"';
    }

    public function cssRegister(){
        if($this->request->getParam('action') == 'add')
            return 'class="loginAction active"';
        return 'class="loginAction"';
    }


}
