<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Participante extends Entity {

    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
