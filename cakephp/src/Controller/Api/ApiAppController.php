<?php

namespace App\Controller\Api;

use App\Controller\AppController as ParentController;

class ApiAppController extends ParentController {
    
    function getParsedData() {
        //The best i could manage
        return json_decode($this->request->getData()[0],true);
        //TODO testar sem o enconde nos testes
     }
           
}



