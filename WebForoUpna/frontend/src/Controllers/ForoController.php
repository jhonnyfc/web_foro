<?php

namespace Foroupna\Controllers;

use Foroupna\Models\Session;
use Foroupna\Models\BackendConx;
use Exception;
use Foroupna\Models\Foro;
use Foroupna\Models\Navigate;
use Foroupna\Models\Paginado;

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

    public function showForo($id_foro){
        if ($id_foro <= 0){
            http_response_code(400);
            return 'Erroren el id del foro';
        }

        $id_foro = Sanitizer::sanitize($id_foro);
        $numRowXPag = 2;
        $paginaActual = 1;

        $data = array(
            "id_foro" => $id_foro,
            "numRowXPag" => $numRowXPag,
            "pagina" => $paginaActual
        );

        try {
            $forodata = BackendConx::getInstance()->getCall("foro/getforobyid/".$id_foro);
            $commentsData = BackendConx::getInstance()->postCall("foro/getcommentbyforo",$data);
            $comments = $commentsData[1];
            $numroTotalFilas = $commentsData[0];

            $mumPages = round($numroTotalFilas / $numRowXPag);
            
            return Foro::makeForo($forodata,$comments,$id_foro,$mumPages,$paginaActual);
        } catch (Exception $ex) {
            http_response_code(400);
            return $ex->getMessage();
        }
    }

    public function loadComments(){
        if (
            empty($_POST['id_foro'])
            || empty($_POST['pagina'])
        ) {
            http_response_code(400);
            return 'Datos vacios';
        }

        $numRowXPag = 2;
        $id_foro = Sanitizer::sanitize($_POST['id_foro']);
        $pagina = Sanitizer::sanitize($_POST['pagina']);

        $dataPost = array(
            "id_foro" => $id_foro,
            "numRowXPag" => $numRowXPag,
            "pagina" => $pagina
        );

        try {
            $commentsData = BackendConx::getInstance()->postCall("foro/getcommentbyforo",$dataPost);
            $comments = $commentsData[1];
            $numroTotalFilas = $commentsData[0];

            $mumPages = round($numroTotalFilas / $numRowXPag);

            $htmlCommets = Foro::makeComments($comments);
            $htmlPaginado = Paginado::makePaginado($id_foro,$mumPages,$pagina);
            
            $data = array(
                0 => $htmlCommets,
                1 => $htmlPaginado
            );

            return json_encode($data,true);
        } catch (Exception $ex) {
            http_response_code(400);
            return $ex->getMessage();
        }
    }
}