<?php

namespace App\Utils;

class StringUtils {
    
    public static function extractParamters($params){
        if(empty($params)){
            return (object)[ 'success' => true, 'values' => []];
        }
        if(!preg_match("/\((\w*)(,\w+)*\)/",$params)){
            return (object)[ 'success' => false, 'error' => "O valor desse parametro deve estar entre parenteses"];
        }
        
        $pureValues = preg_replace("/\(|\)/","",$params);
        if(empty($pureValues)){
            return (object)[ 'success' => true, 'values' => []];
        }
        
        $values = explode(",",$pureValues);
        return (object)[ 'success' => true, 'values' => $values];
    }
    
}
