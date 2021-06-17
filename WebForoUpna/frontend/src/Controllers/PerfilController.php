<?php

namespace Foroupna\Controllers;

use Exception;
use Foroupna\Models\Perfil;

class PerfilController
{
    public function __construct()
    {
        try {
            $_POST = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
        } catch (Exception $e) {
            // http_response_code(500);
        }
    }

    public function showPerfil(){
        try {
            return Perfil::makePerfil();
        } catch (Exception $ex) {
            http_response_code(400);
            return $ex->getMessage();
        }
    }

    public function showPerfilEditiar(){
        try {
            return Perfil::makeEditarPerfil();
        } catch (Exception $ex) {
            http_response_code(400);
            return $ex->getMessage();
        }
    }
}
