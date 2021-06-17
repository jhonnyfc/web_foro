<?php

namespace Foroupna\Controllers;

use Exception;
use Foroupna\Models\Buscador;
use Foroupna\Models\BackendConx;
use Foroupna\Models\Paginado;

class BuscadorController
{
    public function __construct()
    {
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

    public function buscar(){
        if (
            empty($_POST['titulo'])
            || empty($_POST['pagina'])
        ) {
            http_response_code(400);
            return 'Campos introducidos erroneos';
        }

        $numRowXPag = 6;
        $titulo = Sanitizer::sanitize($_POST['titulo']);
        $pagina = Sanitizer::sanitize($_POST['pagina']);

        $dataPost = array(
            "titulo" => $titulo,
            "numRowXPag" => $numRowXPag,
            "pagina" => $pagina
        );

        try {
            $resbusquedaData = BackendConx::getInstance()->postCall("foro/buscador",$dataPost);
            $resbusqueda = $resbusquedaData[1];
            $numroTotalFilas = $resbusquedaData[0];

            $numPages = ceil($numroTotalFilas / $numRowXPag);

            $htmlBusqueda = Buscador::makeResultados($resbusqueda);
            $htmlPaginado = Paginado::makePaginado($titulo,$numPages,$pagina);
            
            $data = array(
                0 => $htmlBusqueda,
                1 => $htmlPaginado
            );

            return json_encode($data,true);
        } catch (Exception $ex) {
            http_response_code(400);
            return $ex->getMessage();
        }
    }
}
