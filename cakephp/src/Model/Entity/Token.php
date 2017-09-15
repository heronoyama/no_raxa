<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Security;
use Cake\Core\Configure;
use App\Model\Entity\EntityErrorTrait;

class Token extends Entity {

    use EntityErrorTrait;

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
