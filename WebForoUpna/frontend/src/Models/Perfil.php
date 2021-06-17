<?php

namespace Foroupna\Models;

use Exception;
use Foroupna\Models\BackendConx;
use Foroupna\Models\Navigate;
use Foroupna\Models\Header;

class Perfil
{
    private static $linkSheet = "<link rel='stylesheet' href='##nav##res/css/perfil.css'>";
    private static $linkScript = "<script src='../res/js/perfil.js'></script>";
    public function __construct()
    {
    }

    public static function makePerfil(){
        try{
            $user = BackendConx::getInstance()->getCall("user/getUser");

            $navMove = "";
            $html = Header::makeHeader($navMove);

            $sheet = str_replace("##nav##",$navMove,self::$linkSheet);
            $librerias = $sheet;
            $html = str_replace("##MdasLinksCss##",$librerias,$html);

            $perfil = file_get_contents(dirname(__FILE__)."/templates/perfil.html");
            $perfil = str_replace("##username##",$user["username"],$perfil);
            $perfil = str_replace("##email##",$user["email"],$perfil);
            $perfil = str_replace("##foto##",$user["foto_url"],$perfil);

            $html = str_replace("##body##",$perfil,$html);
            return $html;
        } catch (Exception $e){
            Navigate::redirect("home");
        }
    }

    public static function makeEditarPerfil(){
        try{
            $user = BackendConx::getInstance()->getCall("user/getUser");

            $navMove = "../";
            $html = Header::makeHeader($navMove);

            $sheet = str_replace("##nav##",$navMove,self::$linkSheet);
            $librerias = $sheet.self::$linkScript;
            $html = str_replace("##MdasLinksCss##",$librerias,$html);

            $perfil = file_get_contents(dirname(__FILE__)."/templates/perfileditar.html");
            $perfil = str_replace("##username##",$user["username"],$perfil);
            $perfil = str_replace("##email##",$user["email"],$perfil);
            $perfil = str_replace("##foto##",$user["foto_url"],$perfil);

            $html = str_replace("##body##",$perfil,$html);
            return $html;
        } catch (Exception $e){
            Navigate::redirect("home");
        }
    }
}
