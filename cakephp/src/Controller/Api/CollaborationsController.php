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
    
    public function add() {
        $collaboration = $this->Collaborations->newEntity();
        
        if (!$this->request->is('post')) {
            $response = $this->response->withStatus(400)->withStringBody(json_encode(["message"=>"Método não permitido"]));
            return $response;
        }
        
        if(!$this->saveModel($collaboration)){
            $response = $this->response->withStatus(400)->withStringBody(json_encode($collaboration->errors()));
            return $response;
        }
        
        $completeCollaboration = $this->Collaborations->loadInto($collaboration,['Participantes','Consumables']);
        $this->set('collaboration',$completeCollaboration);
        $this->set('_serialize', ['collaboration']);
    }
    
    protected function controller() {
        return $this->Collaborations;
    }

}
