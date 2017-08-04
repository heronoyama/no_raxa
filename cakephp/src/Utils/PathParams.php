<?php

namespace App\Utils;

class PathParams {

    public static function extractInclude($params) {
        if (empty($params)) {
            return PathParams::success([]);
        }
        if (!preg_match("/\((\w*)(,\w+)*\)/", $params)) {
            return PathParams::errorMessage("O valor desse parametro deve estar entre parenteses");
        }

        $pureValues = preg_replace("/\(|\)/", "", $params);
        if (empty($pureValues)) {
            return PathParams::success([]);
        }

        $values = explode(",", $pureValues);
        return PathParams::success($values);
    }

    public static function extractIn($params) {
        $errorMessage = "O valor desse parametro deve ser no formato in(numeros)";
        
        if (!isset($params)) {
            return PathParams::errorMessage("Não setado");
        }
        
        if (empty($params)) {
            return PathParams::errorMessage($errorMessage);
        }

        if (!preg_match("/in\((\d*)(,\d+)*\)/", $params)) {
            return PathParams::errorMessage($errorMessage);
        }
        $pureValues = preg_replace("/in\(|\)/", "", $params);

        if (empty($pureValues)) {
            return PathParams::success([]);
        }
        $values = explode(",", $pureValues);
        return PathParams::success(array_map('intval', $values));
    }
    
    
    private static function errorMessage($message) {
        return (object) ['success' => false, 'error' => $message];
    }

    private static function success(array $values) {
        return (object) ['success' => true, 'values' => $values];
    }

}
