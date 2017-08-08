<?php

namespace App\Utils;
use Cake\Datasource\ModelAwareTrait;

class MatrizConsumo {
    use ModelAwareTrait;
    private $consumos;
    
    public function __construct($idEvento){
        $this->loadModel("Consumptions");
        $contain = ['contain' => ['Consumables','Participantes']];
        $where = [$this->Consumptions->alias().'.eventos_id'=>$idEvento];
        $this->consumos = $this->Consumptions->find('all',$contain)->where($where);
    }
    
    public function headers(){
        return ['Participante','Consumível'];
    }
    
    public function getData(){
        $result = [];
        foreach($this->consumos as $consumo){
            $data = [];
            $data['participante'] = $consumo->participante->nome;
            $data['consumivel'] = $consumo->consumable->nome;
            array_push($result,$data);
        }
        
        return $result;
    }
    
}