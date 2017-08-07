<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Consumption extends Entity {

    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
    
    
    
    public function errorMessage(){
        $errors = $this->errors();
        if(!$errors){
            return "";
        }
        $message = "";
        foreach($errors as $key => $value){
            foreach($value as $constraint => $errorMessage){
                $message .=__($errorMessage);
            }
        }
        return $message;
    }
    
 
}
