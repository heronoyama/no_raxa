<?php

namespace App\Controller\Api;

use App\Controller\AppController as ParentController;
use App\Utils\StringUtils;

class ApiAppController extends ParentController {
    
    protected function toInclude(){
        $includesString = $this->request->query("include");
        
        return StringUtils::extractParamters($includesString);
        
    }
    
    protected function responseWithMessage($status,$message){
        return $this->response->withStatus($status)->withStringBody(json_encode(["message"=>$message]));
    }
    
}



