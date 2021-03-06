<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Model\Entity\EntityErrorTrait;


class Consumable extends Entity {
    use EntityErrorTrait;
    
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
    
    public function getCustoTotal(){
        $valor = 0;
        foreach($this->collaborations as $collaboration){
            $valor += $collaboration->value;
        }
        return $valor;
    }
    
    public function getCustoPorParticipante(){
        
        $participantes = sizeof($this->consumptions);
        if($participantes == 0){
            return 0;
        }
        
        $valor = $this->getCustoTotal();
        return $valor/$participantes;
        
    }
}
