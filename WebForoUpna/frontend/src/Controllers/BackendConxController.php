<?php

namespace Foroupna\Controllers;

use Exception;
use Foroupna\Models\BackendConx;

class BackendConxController
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

    public function logIn(){
        if (
            empty($_POST['username'])
            || empty($_POST['password'])
        ) {
            http_response_code(400);
            return 'Campos Vacios';
        }

        $username = Sanitizer::sanitize($_POST['username']);
        $password = Sanitizer::sanitize($_POST['password']);

        $data = array(
            "username" => $username,
            "password" => $password
        );
        

        try{
            $res = BackendConx::getInstance()->postCall("user/login",$data);
            return json_encode($res,true);
        } catch (Exception $e){ 
            http_response_code(400);
            return $e->getMessage();
        }
    }

    public function logOut(){
        try{
            $res = BackendConx::getInstance()->getCall("user/logout");
            session_destroy();
            return json_encode($res,true);
        } catch (Exception $e){ 
            http_response_code(400);
            return $e->getMessage();
        }
    }

    public function checkUser(){
        try{
            $res = BackendConx::getInstance()->getCall("user/getUser");
            return json_encode($res,true);
        } catch (Exception $e){ 
            http_response_code(400);
            return $e->getMessage();
        }
    }
}
