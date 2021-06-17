<?php

namespace Foroupna\Models;

use Exception;
use Foroupna\Models\Navigate;
use mysqli_sql_exception;
use PHPMD\Utility\Strings;



class Buscador
{
    private static $linkSheet = "<link rel='stylesheet' href='res/css/buscador.css'>";
    private static $linkSheet2 = "<link rel='stylesheet' href='res/css/paginado.css'>";
    private static $linkScript = "<script src='res/js/buscador.js'></script>";

    public function __construct()
    {
    }

    public static function makeBuscador():string {
        $html = Header::makeHeader(""); ;
        $librerias = self::$linkSheet.self::$linkScript.self::$linkSheet2;
        $html = str_replace("##MdasLinksCss##",$librerias,$html);

        $login = file_get_contents(dirname(__FILE__)."/templates/buscador.html");
        $html = str_replace("##body##",$login,$html);
        $html = str_replace("##resulatados##","<br><br><br><h2>Realiza tu busqueda...</h2>",$html);
        $html = str_replace("##paginado##","",$html);
        return $html;
    }

    public static function makeResultados($resbusqueda):string {
        $commentTemp = file_get_contents(dirname(__FILE__)."/templates/buscadorForoCard.html");
        $html = "";
        foreach ($resbusqueda as $row){
            $aux = str_replace("##titulo##",'#'.$row["id_foro"]." ".$row["titulo"],$commentTemp);
            $aux = str_replace("##username##",$row["username"],$aux);
            $aux = str_replace("##idforo##",$row["id_foro"],$aux);
            $aux = str_replace("##resforo##",substr($row["descripcion"],0,150)."...",$aux);
            $html .= $aux;
        }
        return $html;
    }
}
