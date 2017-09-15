<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Model\Entity\EntityErrorTrait;

class Evento extends Entity {

    use EntityErrorTrait;

    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public function isOwnedBy($idUser){
        return $this->users_id == $idUser;
    }
}
