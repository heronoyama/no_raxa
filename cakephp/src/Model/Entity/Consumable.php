<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Consumable extends Entity {

    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
