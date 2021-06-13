<?php

namespace Foroupna\Controllers;

use Exception;
use Foroupna\Models\Re;
use Foroupna\Models\Resurce;

class ResurceController
{
    public function __construct()
    {
        try {
            $_POST = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
        } catch (Exception $e) {
            // http_response_code(500);
        }
    }

    public function getCss($cssname){
        $cssname = Sanitizer::sanitize($cssname);

        try {
            return Resurce::findCss($cssname);
        } catch (Exception $e){
            http_response_code(400);
            return "Fichero no encontrado";
        }
    }

    public function getDefFoto($fotoName){
        $fotoName = Sanitizer::sanitize($fotoName);

        try {
            return Resurce::findDefFoto($fotoName);
        } catch (Exception $e){
            http_response_code(400);
            return "Fichero no encontrado";
        }
    }
}
