<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Log\LogTrait;

class Participante extends Entity {
    use LogTrait;

    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
    
    
    public function getValorColaborado(){
        $valor = 0;
        foreach($this->collaborations as $collaboration){
            $valor += $collaboration->value;
        }
        return $valor;
    }
    
    public function getValorDevido(){
        $valor = 0;

        foreach($this->consumptions as $consumption){
            $valor += $consumption->consumable->custo_por_participante;
        }
        return $valor;
    }
}
