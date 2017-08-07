<?php

namespace App\Utils;
use Cake\Datasource\ModelAwareTrait;

class DetalhamentoConsumivel {
    use ModelAwareTrait;
    
    private $participantes;
    private $consumivel;
    
    public function __construct($idEvento,$idConsumivel) {
        
        $this->setParticipantes($idEvento);
        $this->setConsumable($idConsumivel);
    }
    
    private function setConsumable($idConsumivel){
        $this->loadModel("Consumables");
        $this->consumivel = $this->Consumables
                ->get($idConsumivel,['contain'=>['Collaborations','Consumptions']]);
    }
    
    private function setParticipantes($idEvento){
           $this->loadModel("Participantes");
        $participantes = $this->Participantes
                ->find('all', ['contain' => ['Collaborations', 'Consumptions']])
                ->where([$this->Participantes->alias().'.eventos_id'=>$idEvento]);
        foreach($participantes as $participante){
            $this->participantes[$participante->id] = $participante;
        }
    }
    
    public function getData(){
        $result = [];
        $result['id'] = $this->consumivel->id;
        $result['nome'] = $this->consumivel->nome;
        
        $result['consumptions'] = [];
        foreach($this->consumivel->consumptions as $consumption){
            $participante = $this->participantes[$consumption['participantes_id']];
            $dataConsumable['participante'] = $participante->nome;
            $dataConsumable['id'] = $participante->id;
            
            array_push($result['consumptions'],$dataConsumable);
        }
        
        $result['collaborations'] = [];
        foreach($this->consumivel->collaborations as $collaboration){
            $participante = $this->participantes[$collaboration['participantes_id']];
            $dataCollaboration['participante'] = $participante->nome;
            $dataCollaboration['valor_colaborado'] = $collaboration->value;
            array_push($result['collaborations'],$dataCollaboration);
        }
                
        return $result;
    }
    
}