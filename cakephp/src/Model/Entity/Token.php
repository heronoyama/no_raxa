<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Security;
use Cake\Core\Configure;

class Token extends Entity {

    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    protected $_hidden = [
        'token'
    ];

    public function getToken() {
       return Security::hash(Configure::read('Security.salt') . $this->created . date('Ymd'));
    }

    public function getFullToken(){
        return $this->token.'-'.$this->getToken();
    }
}
