<?php

namespace Foroupna\Models;

use Exception;

class Resurce
{
    public function __construct()
    {
        try {
            $_POST = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
        } catch (Exception $e) {
            // http_response_code(500);
        }
    }

    public static function findCss($cssname):string {
        $fichero = file_get_contents(dirname(__FILE__)."/templates/res/css/$cssname");
        if (!(gettype($fichero) === "string")) {
            throw new Exception("Fichero no encontrado");
            // return $result;
        }

        return $fichero;
    }

    public static function findDefFoto($fotoName):string {
        $fichero = file_get_contents(dirname(__FILE__)."/templates/res/$fotoName");
        if (!(gettype($fichero) === "string")) {
            throw new Exception("Fichero no encontrado");
            // return $result;
        }

        return $fichero;
    }
}
