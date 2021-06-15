<?php

namespace Foroupna\Models;

use Exception;
use Foroupna\Models\BackendConx;
use Foroupna\Models\Navigate;
use Foroupna\Models\Header;

class Perfil
{
    private static $linkSheet = "<link rel='stylesheet' href='res/css/perfil.css'>";
    public function __construct()
    {
    }

    public static function makePerfil(){
        try{
            $user = BackendConx::getInstance()->getCall("user/getUser");

            $html = Header::makeHeader("");

            $librerias = self::$linkSheet;
            $html = str_replace("##MdasLinksCss##",$librerias,$html);

            $perfil = file_get_contents(dirname(__FILE__)."/templates/perfil.html");
            $perfil = str_replace("##username##",$user["username"],$perfil);
            $perfil = str_replace("##email##",$user["email"],$perfil);

            $html = str_replace("##body##",$perfil,$html);
            return $html;
        } catch (Exception $e){
            Navigate::redirect("home");
        }
    }
}
