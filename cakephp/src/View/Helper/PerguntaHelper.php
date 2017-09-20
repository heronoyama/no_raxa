<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;


class PerguntaHelper extends Helper {

    public $helpers = ['Form'];

    protected $_defaultConfig = [];

    public function printPergunta($pergunta){
        $type = $this->getType($pergunta);
        $options = [
            'type'=>$type,
            'label'=>false
        ];
        $questionId = 'Pergunta.'.$pergunta->id;

        echo '<div>';
        echo '<legend> '.$pergunta->pergunta.'</legend>';
        echo $this->Form->input($questionId, $options);
        echo '</div>';

    }

    private function getType($pergunta){
        switch($pergunta->tipoResposta){
            case 'Booleano':
                return 'checkbox';
            case 'Texto':
                 return 'text';
            case 'Numerico':
                return 'number';
        }
    }

    
}
