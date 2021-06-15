<?php

namespace Foroupna\Models;

use Exception;
use mysqli_sql_exception;
use PHPMD\Utility\Strings;



class Foro
{
    private static $linkSheet = "<link rel='stylesheet' href='../res/css/foro.css'>";
    private static $linkScript = "<script src='../res/js/foro.js'></script>";

    public function __construct()
    {
        // session_start();
        if(!isset($_COOKIE["PHPSESSID"]))
        {
            session_start();
        }
    }

    public static function makeForo($forodata):string {
        $html = Header::makeHeader("../"); 
        $librerias = self::$linkSheet.self::$linkScript;
        $html = str_replace("##MdasLinksCss##",$librerias,$html);

        // $topForos = Home::makeTopForo($foros);
        // $lastComments = Home::makeTopComments($comments);

        $foro = file_get_contents(dirname(__FILE__)."/templates/foro.html");
        $foro = str_replace("##id_foro##",$forodata["id_foro"],$foro);
        $foro = str_replace("##TituloForo##",$forodata["titulo"],$foro);
        $foro = str_replace("##urlfor##",$forodata["foto_url"],$foro);
        $foro = str_replace("##username##",$forodata["username"],$foro);
        $foro = str_replace("##textodescripcion##",$forodata["descripcion"],$foro);

        $html = str_replace("##body##",$foro,$html);
        
        // $html = str_replace("##TOPFORO##",$topForos,$html);
        // $html = str_replace("##lasCommentr##",$lastComments,$html);

        return $html;
    }

    public static function makeComments($comments):string {
        $topForo = file_get_contents(dirname(__FILE__)."/templates/homeComment.html");
        $html = "";
        foreach ($comments as $row){
            $aux = str_replace("##Titulo##","Foro: #".$row["id_foro"],$topForo);
            $aux = str_replace("##username##",$row["username"],$aux);
            $aux = str_replace("##Resumen##",substr($row["comentario"],0,150)."...",$aux);
            $html .= $aux;
        }
        return $html;
    }
}
