<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Model\Entity\EntityErrorTrait;

class Collaboration extends Entity {

    use EntityErrorTrait;
   
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
    
    public function addValue($newValue){
        $this->value += $newValue;
    }
    
}
