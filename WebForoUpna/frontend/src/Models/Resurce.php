<?php

namespace Foroupna\Models;

use Exception;
require_once __DIR__ . "/../config/config.php";

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
        $fichero = str_replace("##ORIGIN_NAME##",ORIGIN_NAME,$fichero);

        if (!(gettype($fichero) === "string")) {
            throw new Exception("Fichero no encontrado");
            // return $result;
        }

        return $fichero;
    }

    public static function findDefFoto($fotoName):string {
        $fichero = file_get_contents(dirname(__FILE__)."/templates/res/$fotoName");
        $fichero = str_replace("##ORIGIN_NAME##",ORIGIN_NAME,$fichero);

        if (!(gettype($fichero) === "string")) {
            throw new Exception("Fichero no encontrado");
            // return $result;
        }

        return $fichero;
    }

    public static function findJs($jsname):string {
        $fichero = file_get_contents(dirname(__FILE__)."/templates/res/js/$jsname");
        $fichero = str_replace("##ORIGIN_NAME##",ORIGIN_NAME,$fichero);

        if (!(gettype($fichero) === "string")) {
            throw new Exception("Fichero no encontrado");
            // return $result;
        }

        return $fichero;
    }
}