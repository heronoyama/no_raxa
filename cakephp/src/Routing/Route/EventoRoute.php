<?php

namespace App\Routing\Route;
use Cake\Routing\Route\DashedRoute as CakeRoute;
use App\Model\Table\EventosTable;
use Cake\ORM\TableRegistry;

class EventoRoute extends CakeRoute{

	public function parse($url, $method = ''){
		$params = parent::parse($url);
		if(!$params)
			return false;
                
		$idEvento = $params['idEvento'];
		$this->Eventos = TableRegistry::get('Eventos', 
        	['className' => EventosTable::class]);
		$evento = $this->Eventos->get($idEvento);

		$params['pass'] = [$evento];
		if(isset($params['id']))
			 array_push($params['pass'],$params['id']);
					

                 
		return $params;
		//TODO testar e refatorar
	}

}