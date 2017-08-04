<?php

namespace App\Controller\Api;

use App\Controller\AppController as ParentController;
use App\Utils\PathParams;

class ApiAppController extends ParentController {
    
    protected function toInclude(){
        $includesString = $this->request->getQuery("include");
                
        return PathParams::extractInclude($includesString);
    }
    
    protected function filter(){
        $participantesFilter = $this->filterParticipantes();
        $consumablesFilter = $this->filterConsumables();
        
        if(!$participantesFilter && !$consumablesFilter){
            return (object)['filtered' => false];
        }

        $result = [];
        if($participantesFilter){
            $result = array_merge($result,$participantesFilter);
        }
        
        if($consumablesFilter){
            $result = array_merge($result,$consumablesFilter);
        }
        
        return (object)['filtered'=>true,'conditions'=>$result];
    }
    
    private function filterParticipantes(){
        $participantes = $this->request->getQuery("participantes");
        
        
        if(!isset($participantes)){
            return false;
        }
        
        $valuesParticipantes = PathParams::extractIn($participantes)->values;
        $this->loadModel("Participantes");
        return [$this->Participantes->alias().'.id in' => $valuesParticipantes];
    }
    
    private function filterConsumables(){
        $consumables = $this->request->getQuery("consumiveis");
        
        if(!isset($consumables)){
            return false;
        }
        $valuesConsumables = PathParams::extractIn($consumables)->values;
        $this->loadModel("Consumables");
        return [$this->Consumables->alias().'.id in' => $valuesConsumables];
    }
    
    protected function responseWithMessage($status,$message){
        return $this->response->withStatus($status)->withStringBody(json_encode(["message"=>$message]));
    }
    
}



