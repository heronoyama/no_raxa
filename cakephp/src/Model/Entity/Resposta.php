<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Resposta extends Entity {

    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public function getResposta(){
        if($this->pergunta)
        $tipoResposta = $this->pergunta->tipoResposta;

        if($tipoResposta == 'Booleano')
            return intval($this->resposta) ? 'SIM' : 'NÃO';

        if($tipoResposta == 'Numerico')
            return intval($this->resposta);
            
        return $this->resposta;
    }
}
