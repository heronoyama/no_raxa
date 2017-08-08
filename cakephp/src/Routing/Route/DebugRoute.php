<?php

namespace App\Routing\Route;
use Cake\Routing\Route\DashedRoute as CakeRoute;
use Cake\Log\LogTrait;

class DebugRoute extends CakeRoute{
    use LogTrait;
    
    public function parse($url, $method = ''){
		$params = parent::parse($url);
                $this->log($params,'debug');
                 
		return $params;
		
	}
}