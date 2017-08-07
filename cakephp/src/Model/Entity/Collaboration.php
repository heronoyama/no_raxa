<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Collaboration extends Entity {
   
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
    
    public function addValue($newValue){
        $this->value += $newValue;
    }
    
}
