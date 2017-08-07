<?php

namespace App\Utils;
use Cake\Datasource\ModelAwareTrait;

class BalancoConsumiveis {
    use ModelAwareTrait;
    
    private $consumables;
    
    public function __construct($idEvento) {
        $this->setConsumables($idEvento);
    }
    
    private function setConsumables($idEvento){
        $this->loadModel("Consumables");
        $consumables = $this->Consumables
                ->find('all',['contain'=>['Collaborations','Consumptions']])
                ->where([$this->Consumables->alias().'.eventos_id'=>$idEvento]);
        $this->consumables = $consumables;
        
    }
    
    public function getData(){
        $result = [];
        foreach($this->consumables as $consumable){
            $dataConsumable = [];
            $dataConsumable['id'] = $consumable->id;
            $dataConsumable['nome'] = $consumable->nome;
            $dataConsumable['valor_investido'] = $consumable->getCustoTotal();
            $dataConsumable['valor_por_participante'] = $consumable->getCustoPorParticipante();
            array_push($result,$dataConsumable);
        }
        return $result;
    }
    
}