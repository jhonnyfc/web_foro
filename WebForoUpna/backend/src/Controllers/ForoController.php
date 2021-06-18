<?php

namespace Foroupna\Controllers;

use Foroupna\Models\Session;
use Exception;
use Foroupna\Controllers\FileController;
use Foroupna\Models\Foro;
use Foroupna\Models\Comment;
require_once __DIR__ . "/../config/config.php";

class ForoController
{
    public function __construct()
    {
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
        $nuevo_ancho = 298;
        $nuevo_alto = 152;

        try {
            $dir = dirname(dirname(dirname(__FILE__))).DIR_FOTOS_FORO;
            $data = FileController::uploadFoto($dir,$fotoname,$nuevo_ancho,$nuevo_alto,false);
            // echo $data;
            return json_encode(array(0 => $data),true);
            // return $data;
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
            $res = Comment::insertComment($comentario,$id_foro,$username);
            return json_encode(array(0 => $res),true);
        } catch (Exception $e){
            http_response_code(400);
            return 'Error al crear foro'.$e->getMessage();
        }
    }

    public function buscaForo(){
        if (
            empty($_POST['titulo'])
            || empty($_POST['numRowXPag'])
            || empty($_POST['pagina'])
        ) {
            http_response_code(400);
            return 'Datos vacios back';
        }

        $titulo = Sanitizer::sanitize($_POST['titulo']);
        $numRowXPag = Sanitizer::sanitize($_POST['numRowXPag']);
        $pagina = Sanitizer::sanitize($_POST['pagina']);

        try {
            $numTotalRows = Foro::countNumRowsForo($titulo);
            $data = Foro::buscaForo($titulo,$numRowXPag,$pagina);

            $dataOut = array(
                0 => $numTotalRows,
                1 => $data                
            );

            return json_encode($dataOut,true);
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
            $res = Comment::getLastNcomment($number);
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

    public function getCommentsByForoId(){
        if (
            empty($_POST['id_foro'])
            || empty($_POST['numRowXPag'])
            || empty($_POST['pagina'])
        ) {
            http_response_code(400);
            return 'Datos vacios';
        }

        $numRowXPag = Sanitizer::sanitize($_POST['numRowXPag']);
        $id_foro = Sanitizer::sanitize($_POST['id_foro']);
        $pagina = Sanitizer::sanitize($_POST['pagina']);

        try {
            $numTotalRows = Foro::countNumRowsCommentForo($id_foro);
            $res = Foro::getCommentsByForoId($id_foro,$numRowXPag,$pagina);

            $data = array(
                0 => $numTotalRows,
                1 => $res
            );

            return json_encode($data,true);
        } catch (Exception $e){
            http_response_code(400);
            return 'Error al crear foro'.$e->getMessage();
        }
    }
}
