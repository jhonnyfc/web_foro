<?php

namespace Foroupna\Controllers;

use Foroupna\Models\Session;
use Exception;
use Foroupna\Models\Foro;

class ForoController
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

    public function createForo(): string{
        if ( Session::get('user') === null ) {
            http_response_code(400);
            return "You must login.";
        }
        
        if (
            empty($_POST['titulo'])
            || empty($_POST['username'])
            || empty($_POST['descripcion'])
        ) {
            http_response_code(400);
            return 'Bad request error.';
        }

        $titulo = Sanitizer::sanitize($_POST['titulo']);
        $username = Sanitizer::sanitize($_POST['username']);
        $descripcion = Sanitizer::sanitize($_POST['descripcion']);

        try {
            $res = Foro::makeForo($titulo,$username,$descripcion);
            return json_encode(array(0 => $res),true);
        } catch (Exception $e){
            http_response_code(400);
            return 'Error al crear foro'.$e->getMessage();
        }
    }

    public function uploadFoto(): string{
        if ( Session::get('user') === null ) {
            //User::redirect("http://localhost:1234/");
            http_response_code(400);
            return "You must login.";
        }

        if (
            empty($_POST['fotoname'])
            || empty($_FILES)
        ) {
            http_response_code(400);
            return 'Bad request error.';
        }

        $fotoname = Sanitizer::sanitize($_POST['fotoname']);

        try {
            $res = Foro::updateFoto($fotoname);

            // TODO
            // Guardamos la foto en el fichero habra que poner la ruta exta para subir los ficheros
            $dir = dirname( dirname(__FILE__) );
            $dir .= '\\frontend\\fotos_ejercicios\\';

            if(!empty($_FILES)){
                

                $temp_file = $_FILES['file']['tmp_name'];
                $location = $dir . $_FILES['file']['name'];

                $nuevo_ancho = 1000;
                $nuevo_alto = 1000;
                header('Content-type: image/jpeg');
                $thumb = self::mo_resizeImage($temp_file,$nuevo_ancho,$nuevo_alto);
                // move_uploaded_file($thumb , $location);
                if (!imagejpeg($thumb , $location)){
                    header("HTTP/1.0 400 Bad Request");
                    echo 'Erro camibar redmimensioanar archivo';
                }
            } else {
                header("HTTP/1.0 400 Bad Request");
                echo 'Erro al subir archivo';
            }

            return json_encode(array(0 => $res),true);
        } catch (Exception $e){
            http_response_code(400);
            return 'Error al crear foro'.$e->getMessage();
        }

        return "lol";
    }

    public static function mo_resizeImage($temp_file,$nuevo_ancho,$nuevo_alto){
        list($ancho, $alto) = getimagesize($temp_file);

        // Cargar
        $thumb = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);
        $origen = imagecreatefromjpeg($temp_file);

        // Cambiar el tamaño
        imagecopyresized($thumb, $origen, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);

        return $thumb;
    }
}
