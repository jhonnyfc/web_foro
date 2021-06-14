<?php

namespace Foroupna\Controllers;

use Exception;
use Foroupna\Models\Buscador;

class BuscadorController
{
    public function __construct()
    {
        session_start();
        try {
            $_POST = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
        } catch (Exception $e) {
            // http_response_code(500);
        }
    }

    public function showBuscador(){
        try {
            return Buscador::makeBuscador();
        } catch (Exception $ex) {
            http_response_code(400);
            return $ex->getMessage();
        }
    }
}