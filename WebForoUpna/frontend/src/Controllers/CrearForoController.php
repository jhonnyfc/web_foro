<?php

namespace Foroupna\Controllers;

use Exception;
use Foroupna\Models\CrearForo;

class CrearForoController
{
    public function __construct()
    {
        try {
            $_POST = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
        } catch (Exception $e) {
            // http_response_code(500);
        }
    }

    public function showCrearForo(){
        try {
            return CrearForo::makeCrearForo();
        } catch (Exception $ex) {
            http_response_code(400);
            return $ex->getMessage();
        }
    }
}
