<?php

namespace Foroupna\Models;

use Exception;
use Foroupna\Models\Navigate;
use mysqli_sql_exception;
use PHPMD\Utility\Strings;



class Login
{
    private static $linkSheet = "<link rel='stylesheet' href='res/css/login.css'>";
    private static $linkScript = "<script src='res/js/login.js'></script>";

    public function __construct()
    {
    }

    public static function makeLogin():string {
        try{
            $result = BackendConx::getInstance()->getCall("user/getUser");
            // Si el Usuario estaba logueado le llevamos a perfil
            // Donde se le cargaran los datos
            Navigate::redirect("perfil");
        } catch (Exception $e){
            $html = Header::makeHeader("");

            $librerias = self::$linkSheet.self::$linkScript;
            $html = str_replace("##MdasLinksCss##",$librerias,$html);

            $login = file_get_contents(dirname(__FILE__)."/templates/login.html");
            $html = str_replace("##body##",$login,$html);
        }
        return $html;
    }
}
