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
            || empty($_POST['descripcion'])
        ) {
            http_response_code(400);
            return 'Bad request error.';
        }

        $titulo = Sanitizer::sanitize($_POST['titulo']);
        $username = Session::get("user");
        $descripcion = Sanitizer::sanitize($_POST['descripcion']);

        try {
            $res = Foro::makeForo($titulo,$username,$descripcion);
            return json_encode(array(0 => $res),true);
        } catch (Exception $e){
            http_response_code(400);
            return 'Error al crear foro'.$e->getMessage();
        }
    }

    public function uploadFoto(){
        if (
            empty($_POST['fotoname'])
            || empty($_FILES)
        ) {
            http_response_code(400);
            return 'Datos vacios';
        }

        $fotoname = Sanitizer::sanitize($_POST['fotoname']);

        try {
            $dir = dirname(dirname(dirname(__FILE__)))."\\public\\imgs\\";

            if(!empty($_FILES)){

                $temp_file = $_FILES['file']['tmp_name'];
                // $location = $dir . $_FILES['file']['name'];
                $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

                if (strcmp($ext,"jpg") != 0 && strcmp($ext,"jpeg") != 0){
                    http_response_code(400);
                    return "La foto debe de ser jpg o jpeg, el foro se quedara sin foto, si quiere subir foto contacte con el administrador, forUpna@email.com";
                }

                echo $fotoname.".".$ext." <br> ".$_FILES['file']['name']." <br>";

                $res = Foro::updateFoto($fotoname.".".$ext);

                $location = $dir.$res;

                $nuevo_ancho = 298;
                $nuevo_alto = 152;
                header('Content-type: image/jpeg');
                $thumb = self::mo_resizeImage($temp_file,$nuevo_ancho,$nuevo_alto);
                // move_uploaded_file($thumb , $location);
                if (!imagejpeg($thumb , $location)){
                    http_response_code(400);
                    return 'Erro camibar redmimensioanar archivo';
                }

                return json_encode(array(0 => "Foto Subida Bien"),true);
            }

            http_response_code(400);
            return 'Erro al subir archivo';
        } catch (Exception $e){
            http_response_code(400);
            return 'Error al crear foro'.$e->getMessage();
        }
    }

    public function cehcDir() {
        $dir = dirname(dirname(dirname(__FILE__)))."\\public\\imgs\\";
        echo var_dump(scandir($dir))."<br>";

        $target_dir = __DIR__ . "/../../public/imgs/";
        echo var_dump(scandir($target_dir))."<br>";
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

    public function getMostComment($number){        
        if ($number <= 0){
            http_response_code(400);
            return 'Erro en el numero de foros solicitado';
        }

        $number = Sanitizer::sanitize($number);

        try {
            $res = Foro::getMostComment($number);
            return json_encode($res,true);
        } catch (Exception $e){
            http_response_code(400);
            return 'Error al crear foro'.$e->getMessage();
        }
    }

    public function insertComment(){
        if ( Session::get('user') === null ) {
            http_response_code(400);
            return "You must login.";
        }

        if (
            empty($_POST['comentario'])
            || empty($_POST['id_foro'])
        ) {
            http_response_code(400);
            return 'Datos vacios';
        }

        $comentario = Sanitizer::sanitize($_POST['comentario']);
        $id_foro = Sanitizer::sanitize($_POST['id_foro']);
        $username = Session::get('user');

        try {
            $res = Foro::insertComment($comentario,$id_foro,$username);
            return json_encode(array(0 => $res),true);
        } catch (Exception $e){
            http_response_code(400);
            return 'Error al crear foro'.$e->getMessage();
        }
    }

    public function buscaForo(){
        if (
            empty($_POST['titulo'])
        ) {
            http_response_code(400);
            return 'Datos vacios';
        }

        $titulo = Sanitizer::sanitize($_POST['titulo']);

        try {
            $res = Foro::buscaForo($titulo);
            return json_encode($res,true);
        } catch (Exception $e){
            http_response_code(400);
            return 'Error al crear foro'.$e->getMessage();
        }
    }

    public function getLastNcomment($number){
        if ($number <= 0){
            http_response_code(400);
            return 'Erro en el numero de foros solicitado';
        }

        $number = Sanitizer::sanitize($number);

        try {
            $res = Foro::getLastNcomment($number);
            // if ($res === ""){
            //     http_response_code(400);
            //     return 'No har comments';
            // } 

            return json_encode($res,true);
        } catch (Exception $e){
            http_response_code(400);
            return 'Error al crear foro'.$e->getMessage();
        }
    }

    public function getForobyId($id_foro){
        if ($id_foro <= 0){
            http_response_code(400);
            return 'Erroren el id del foro';
        }

        $id_foro = Sanitizer::sanitize($id_foro);

        try {
            $res = Foro::findForo($id_foro);

            return json_encode($res,true);
        } catch (Exception $e){
            http_response_code(400);
            return 'Error al crear foro'.$e->getMessage();
        }
    }
}
