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
        if (!$this->request->is('post')) {
            $response = $this->response->withStatus(400)->withStringBody(json_encode(["message"=>"Método não permitido"]));
            return $response;
        }
        $collaboration = $this->Collaborations->addCollaboration($this->getParsedData());
         if(!$collaboration){
            $response = $this->response->withStatus(400)->withStringBody(json_encode($collaboration->errors()));
            return $response;
        }
        
        $this->set('collaboration',$collaboration);
        $this->set('_serialize', ['collaboration']);
    }
    
    public function edit($id = null){
        
        $collaboration = $this->controller()->get($id, [
            'contain' => []
        ]);
        
        if (!$this->request->is('put')) {
            $response = $this->response->withStatus(400)->withStringBody(json_encode(["message"=>"Método não permitido"]));
            return $response;
        }
         
        if(!$this->saveModel($collaboration)){
            $response = $this->response->withStatus(400)->withStringBody(json_encode($collaboration->errors()));
            return $response;
        }
        

        $this->set('collaboration',$collaboration);
        $this->set('_serialize', ['collaboration']);
    }
    
     public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $collaboration = $this->controller()->get($id);
        $success = $this->deleteModel($collaboration);
        
        $message = $success ? "Colaboração deletada com sucesso!" : "Algo deu errado.";
        $this->set('message',$message);
        $this->set('_serialize',['message']);
    }
    
    protected function controller() {
        return $this->Collaborations;
    }

}
