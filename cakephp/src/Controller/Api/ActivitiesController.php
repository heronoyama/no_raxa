<?php
namespace App\Controller\Api;

use App\Controller\Api\AppController;

class ActivitiesController extends AppController{

    public function index(){

        $activities = $this->Activities->find('all');

        $this->set([
        	'activities' => $activities,
            '_serialize' => ['activities']
            ]);
    }

     public function view($id = null){
        $activity = $this->Activities->get($id, [
            'contain' => ['TodoLists']
        ]);

        $this->set([
        	'activity'=> $activity,
        	'_serialize'=> ['activity']
        	]);
    }

}