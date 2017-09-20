<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;


class SurveyHelper extends Helper {

    public $helpers = ['Form','Pergunta'];

    protected $_defaultConfig = [];

    public function printForm($survey){
        echo $this->Form->create('SurveyRespostas',['url'=>['controller'=>'SurveyRespostas','action'=>'register',$survey->id]]);

        foreach($survey->perguntas as $pergunta)
            $this->Pergunta->printPergunta($pergunta);

        echo $this->Form->button("Enviar");
        echo $this->Form->end();
    }

}
