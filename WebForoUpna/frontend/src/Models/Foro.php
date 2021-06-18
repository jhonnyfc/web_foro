<?php

namespace Foroupna\Models;

use Exception;
use mysqli_sql_exception;
use PHPMD\Utility\Strings;
use Foroupna\Models\Paginado;

class Foro
{
    private static $linkSheet = "<link rel='stylesheet' href='../res/css/foro.css'>";
    private static $linkSheet2 = "<link rel='stylesheet' href='../res/css/paginado.css'>";
    private static $linkScript = "<script src='../res/js/foro.js'></script>";

    public function __construct()
    {
    }

    public static function makeForo($forodata,$comments,$id_foro,$numPages,$paginaActual):string {
        $navMove = "../";
        $html = Header::makeHeader($navMove); 
        $librerias = self::$linkSheet.self::$linkScript.self::$linkSheet2;
        $html = str_replace("##MdasLinksCss##",$librerias,$html);

        // $topForos = Home::makeTopForo($foros);
        // $lastComments = Home::makeTopComments($comments);

        $foro = file_get_contents(dirname(__FILE__)."/templates/foro.html");
        $foro = str_replace("##id_foro##",$forodata["id_foro"],$foro);
        $foro = str_replace("##TituloForo##",$forodata["titulo"],$foro);

        if (strcmp($forodata["foto_url"],"res/default.webp") == 0)
            $img = $navMove.$forodata["foto_url"];
        else
            $img = $forodata["foto_url"];
        $foro = str_replace("##urlfor##",$img,$foro);
        
        $foro = str_replace("##username##",$forodata["username"],$foro);
        $foro = str_replace("##textodescripcion##",$forodata["descripcion"],$foro);

        $commentsHtml = self::makeComments($comments);

        $paginado = Paginado::makePaginado($id_foro,$numPages,$paginaActual);

        $html = str_replace("##body##",$foro,$html);        
        $html = str_replace("##comentarios##",$commentsHtml,$html);
        $html = str_replace("##paginado##",$paginado,$html);

        return $html;
    }

    public static function makeComments($comments):string {
        $commentTemp = file_get_contents(dirname(__FILE__)."/templates/foroComment.html");
        $html = "";
        foreach ($comments as $row){
            $aux = str_replace("##username##",$row["username"],$commentTemp);
            $aux = str_replace("##comentario##",$row["comentario"],$aux);
            $html .= $aux;
        }
        return $html;
    }
}
