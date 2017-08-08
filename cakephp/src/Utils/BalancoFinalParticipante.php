<?php

namespace App\Utils;
use Cake\Datasource\ModelAwareTrait;

class BalancoFinalParticipante {
    use ModelAwareTrait;
    
    private $participantes;
    private $consumables;

    public function __construct($idEvento) {
        $this->setParticipantes($idEvento);
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
    
    private function setParticipantes($idEvento){
        $this->loadModel("Participantes");
        $participantes = $this->Participantes
                ->find('all', ['contain' => ['Collaborations', 'Consumptions']])
                ->where([$this->Participantes->alias().'.eventos_id'=>$idEvento]);
        foreach($participantes as $participante){
            $this->participantes[$participante->id] = $participante;
        }
    }
    
    public function headers(){
        return ['ID','Nome','Valor Colaborado','Valor Devido','Valor Final'];
    }
    
    public function getData(){
        $result = [];
        foreach($this->participantes as $id => $participante){
            $dataParticipante = [];
            $dataParticipante['id'] = $id;
            $dataParticipante['nome'] = $participante->nome;
            $dataParticipante['valor_colaborado'] = $participante->getValorColaborado();
            
            $valorDevido = 0;
            foreach($participante->consumptions as $consumption){
                $valorDevido += $this->consumables[$consumption['consumables_id']]->getCustoPorParticipante();
            }
            $dataParticipante['valor_devido'] = $valorDevido;
            $dataParticipante['valor_final'] = $dataParticipante['valor_colaborado'] - $valorDevido;
            array_push($result,$dataParticipante);
        }
        return $result;
    }
    
}