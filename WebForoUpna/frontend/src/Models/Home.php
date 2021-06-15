<?php

namespace Foroupna\Models;

use Exception;
use mysqli_sql_exception;
use PHPMD\Utility\Strings;



class Home
{
    private static $linkSheet = "<link rel='stylesheet' href='res/css/home.css'>";

    public function __construct()
    {
    }

    public static function makeHome($foros,$comments):string {
        $html = Header::makeHeader(""); 
        $html = str_replace("##MdasLinksCss##",self::$linkSheet,$html);

        $topForos = Home::makeTopForo($foros);
        $lastComments = Home::makeTopComments($comments);

        $home = file_get_contents(dirname(__FILE__)."/templates/home.html");
        $html = str_replace("##body##",$home,$html);
        $html = str_replace("##TOPFORO##",$topForos,$html);
        $html = str_replace("##lasCommentr##",$lastComments,$html);

        return $html;
    }

    public static function makeTopForo($foros):string {
        $topForo = file_get_contents(dirname(__FILE__)."/templates/homeForo.html");
        $html = "";
        foreach ($foros as $row){
            $aux = str_replace("##foto##",$row["foto_url"],$topForo);
            $aux = str_replace("##idforo##",$row["id_foro"],$aux);
            $aux = str_replace("##Titulo##","#".$row["id_foro"].": ".substr($row["titulo"],0,17)."...",$aux);
            $html .= $aux;
        }
        return $html;
    }

    public static function makeTopComments($comments):string {
        $topForo = file_get_contents(dirname(__FILE__)."/templates/homeComment.html");
        $html = "";
        foreach ($comments as $row){
            $aux = str_replace("##Titulo##","Foro: #".$row["id_foro"],$topForo);
            $aux = str_replace("##idforo##",$row["id_foro"],$aux);
            $aux = str_replace("##username##",$row["username"],$aux);
            $aux = str_replace("##Resumen##",substr($row["comentario"],0,150)."...",$aux);
            $html .= $aux;
        }
        return $html;
    }
}
