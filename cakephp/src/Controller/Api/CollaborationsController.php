<?php
namespace App\Controller\Api;

use App\Controller\Api\ApiAppController as ApiController;

class CollaborationsController extends ApiController {
    
    public function index($idEvento = null) {

        $contains = ['contain' => ['Participantes','Consumables']];
        $where = [$this->Collaborations->alias().'.eventos_id' => $idEvento];

        $filter = $this->filter();
        
        if($filter->filtered){
           $where = array_merge($where,$filter->conditions);
        }
        
        $collaborations = $this->Collaborations
                    ->find('all',$contains)
                    ->where($where);

        $this->set(compact('collaborations'));
        $this->set('_serialize', ['collaborations']);
    }

}
