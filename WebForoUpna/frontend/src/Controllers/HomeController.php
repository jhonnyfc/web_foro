<?php

namespace Foroupna\Controllers;

use Foroupna\Models\Session;
use Exception;
use Foroupna\Models\Home;
use Foroupna\Models\Navigate;

class HomeController
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

    public function showHome(){
        try {
            return Home::makeHome();
        } catch (Exception $ex) {
            http_response_code(400);
            return $ex->getMessage();
        }
    }

    public static function redirect(): void
    {
        Navigate::redirect("home");
    }
}