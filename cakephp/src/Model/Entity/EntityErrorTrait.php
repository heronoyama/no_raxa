<?php
namespace App\Model\Entity;

trait EntityErrorTrait {

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

