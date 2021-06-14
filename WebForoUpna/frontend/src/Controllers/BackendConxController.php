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

    public function upData(){
        if (
            empty($_POST['titulo'])
            || empty($_POST['descripcion'])
        ) {
            http_response_code(400);
            return 'Campos Vacios';
        }

        $titulo = Sanitizer::sanitize($_POST['titulo']);
        $descripcion = Sanitizer::sanitize($_POST['descripcion']);

        $data = array(
            "titulo" => $titulo,
            "descripcion" => $descripcion
        );

        try {
            $res = BackendConx::getInstance()->postCall("foro/crear",$data);
            return json_encode($res,true);
        } catch (Exception $ex) {
            http_response_code(400);
            return $ex->getMessage();
        }
    }

    public function registar(){
        if (
            empty($_POST['username'])
            || empty($_POST['password'])
            || empty($_POST['email'])
        ) {
            http_response_code(400);
            return 'Bad request error.';
        }

        $username = Sanitizer::sanitize($_POST['username']);
        $password = Sanitizer::sanitize($_POST['password']);
        $email = Sanitizer::sanitize($_POST['email']);

        $data = array(
            "username" => $username,
            "password" => $password,
            "email" => $email
        );

        try {
            $res = BackendConx::getInstance()->postCall("user/signup",$data);
            return json_encode($res,true);
        } catch (Exception $ex) {
            http_response_code(400);
            return $ex->getMessage();
        }
    }
}
