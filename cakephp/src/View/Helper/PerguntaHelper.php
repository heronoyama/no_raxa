<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;


class PerguntaHelper extends Helper {

    public $helpers = ['Form'];

    protected $_defaultConfig = [];

    public function printPergunta($pergunta){
        switch($pergunta->tipoResposta){
            case 'Booleano':
                $this->printBooleano($pergunta);
                break;
            case 'Texto':
                 $this->printTexto($pergunta);
                 break;
            case 'Numerico':
                $this->printNumerico($pergunta);
                break;
        }
    }

    private function printBooleano($pergunta){
        echo '<div>';
        echo '<legend> '.$pergunta->pergunta.'?</legend>';
        echo $this->Form->checkbox($pergunta->id);
        echo '</div>';
    }

    private function printTexto($pergunta){
        echo '<div> ';
        echo $this->Form->control($pergunta->pergunta);
        echo ' </div>';
    }

    private function printNumerico($pergunta){
        echo '<div> ';
        echo $this->Form->control($pergunta->pergunta, ['type' => 'number']);
        echo ' </div>';
    }


}
