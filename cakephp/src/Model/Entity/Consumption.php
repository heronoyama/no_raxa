<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Model\Entity\EntityErrorTrait;

class Consumption extends Entity {

    use EntityErrorTrait;

    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
    
    
    
    
    
 
}
