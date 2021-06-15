<?php

namespace Foroupna\Models;

use Exception;
use Foroupna\Models\Buscador;

class CrearForo
{
    private static $linkSheet = "<link rel='stylesheet' href='res/css/crearForo.css'>";
    private static $linkScript = "<script src='res/js/crearForo.js'></script>";

    public function __construct()
    {
    }

    public static function makeCrearForo(){
        try{
            $html = Header::makeHeader("");

            $librerias = self::$linkSheet.self::$linkScript;
            $html = str_replace("##MdasLinksCss##",$librerias,$html);

            $creaForo = file_get_contents(dirname(__FILE__)."/templates/crearForo.html");
            $html = str_replace("##body##",$creaForo,$html);
            return $html;
        } catch (Exception $e){
            Navigate::redirect("home");
        }
    }
}
