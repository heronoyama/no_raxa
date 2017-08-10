<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;


class Evento extends Entity {

    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public function isOwnedBy($idUser){
        return $this->users_id == $idUser;
    }
}
