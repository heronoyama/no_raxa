<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Security;
use Cake\Core\Configure;

class User extends Entity {

    protected $_accessible = [
        '*' => true,
        'id' => false,
        'token' => false
    ];

    protected function _setPassword($password) {
        return (new DefaultPasswordHasher)->hash($password);
    }

    protected $_hidden = [
        'password',
        'token'
    ];

   public function getToken() {
       return Security::hash(Configure::read('Security.salt') . $this->created . date('Ymd'));
    }

}
