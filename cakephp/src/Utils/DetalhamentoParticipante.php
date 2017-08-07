<?php

namespace App\Utils;
use Cake\Datasource\ModelAwareTrait;

class DetalhamentoParticipante {
    use ModelAwareTrait;

    private $participante;
    private $consumables;
    
    
    public function __construct($idEvento,$idParticipante) {
        
        $this->setParticipante($idParticipante);
        $this->setConsumables($idEvento);
    }    
    
    private function setConsumables($idEvento){
        $this->loadModel("Consumables");
        $consumables = $this->Consumables
                ->find('all',['contain'=>['Collaborations','Consumptions']])
                ->where([$this->Consumables->alias().'.eventos_id'=>$idEvento]);
        foreach($consumables as $consumable){
            $this->consumables[$consumable->id] = $consumable;
        }
    }
    
    private function setParticipante($idParticipante){
        $this->loadModel("Participantes");
        $contain = ['contain' => [
           'Consumptions','Consumptions.Consumables',
           'Collaborations','Collaborations.Consumables'
        ]];
        $this->participante = $this->Participantes->get($idParticipante,$contain);
    }
    
    public function getData(){
        $result= [];
        $result['id'] = $this->participante->id;
        $result['nome'] = $this->participante->nome;

        $result['consumptions'] = [];
        foreach($this->participante->consumptions as $consumption){
            $consumable = $this->consumables[$consumption['consumables_id']];
            $dataConsumable['consumable'] = $consumable->nome;
            $dataConsumable['valor_por_participante'] = $consumable->getCustoPorParticipante();
            array_push($result['consumptions'],$dataConsumable);
        }
        
        $result['collaborations'] = [];
        foreach($this->participante->collaborations as $collaboration){
            $consumable = $this->consumables[$collaboration['consumables_id']];
            $dataCollaboration['consumable'] = $consumable->nome;
            $dataCollaboration['valor_colaborado'] = $collaboration->value;
            array_push($result['collaborations'],$dataCollaboration);
        }
        
        return $result;
    } 
    
    
}

