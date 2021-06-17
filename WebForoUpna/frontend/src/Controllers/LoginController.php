<?php

namespace Foroupna\Controllers;

use Foroupna\Models\Session;
use Exception;
use Foroupna\Models\Login;

class LoginController
{
    public function __construct()
    {
        try {
            $_POST = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
        } catch (Exception $e) {
            // http_response_code(500);
        }
    }

    public function showLogin(){
        try {
            return Login::makeLogin();
        } catch (Exception $ex) {
            http_response_code(400);
            return $ex->getMessage();
        }
    }

    public function login(){
        try {
            return Login::makeLogin();
        } catch (Exception $ex) {
            http_response_code(400);
            return $ex->getMessage();
        }
    }
}
