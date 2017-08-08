<?php

namespace App\Utils;
use Cake\Datasource\ModelAwareTrait;

class MatrizColaboracao {
    use ModelAwareTrait;
    private $colaboracoes;
    
    public function __construct($idEvento){
        $this->loadModel("Collaborations");
        $contain = ['contain' => ['Consumables','Participantes']];
        $where = [$this->Collaborations->alias().'.eventos_id'=>$idEvento];
        $this->colaboracoes = $this->Collaborations->find('all',$contain)->where($where);
    }
    
    public function headers(){
        return ['Participante','Consumível','Valor Colaborado'];
    }
    
    public function getData(){
        $result = [];
        foreach($this->colaboracoes as $colaboracao){
            $data = [];
            $data['participante'] = $colaboracao->participante->nome;
            $data['consumivel'] = $colaboracao->consumable->nome;
            $data['valor'] = $colaboracao->value;
            array_push($result,$data);
        }
        
        return $result;
    }
    
}