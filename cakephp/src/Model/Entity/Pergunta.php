<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Pergunta extends Entity {

    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
