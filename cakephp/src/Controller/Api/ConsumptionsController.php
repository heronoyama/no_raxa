<?php

namespace App\Controller\Api;

use App\Controller\Api\ApiAppController as ParentController;

class ConsumptionsController extends ParentController {
    
    public function index($idEvento = null){
        $where = [$this->Consumptions->alias().'.eventos_id' => $idEvento];
        $contains = ['contain' => ['Participantes','Consumables']];

        $filter = $this->filter();
        
        if($filter->filtered){
           $where = array_merge($where,$filter->conditions);
        }
        
        $consumptions = $this->Consumptions
                    ->find('all',$contains)
                    ->where($where);

        $this->set(compact('consumptions'));
        $this->set('_serialize', ['consumptions']);
    }
    
    public function add() {
        if (!$this->request->is('post')) {
            $response = $this->response->withStatus(400)->withStringBody(json_encode(["message"=>"Método não permitido"]));
            return $response;
        }
        $model = $this->Consumptions->newConsumption($this->getParsedData());
         if(!$this->controller()->save($model)){
            $response = $this->response->withStatus(400)->withHeader("Content-type", "application/json")->withStringBody(json_encode(["message"=>$model->errorMessage()]));
            return $response;
        }
        
        $model = $this->controller()->loadRelations($model);
        
        $this->set('consumption',$model);
        $this->set('_serialize', ['consumption']);
    }
    
    
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $consumo= $this->controller()->get($id);
        $success = $this->deleteModel($consumo);
        
        $message = $success ? "Consumo deletada com sucesso!" : "Algo deu errado.";
        $this->set('message',$message);
        $this->set('_serialize',['message']);
    }
    
    protected function controller() {
        return $this->Consumptions;
    }
}
   