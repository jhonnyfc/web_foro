<?php

namespace Foroupna\Models;

use Exception;
use Foroupna\Models\Navigate;
use mysqli_sql_exception;
use PHPMD\Utility\Strings;



class Login
{
    private static $linkSheet = "<link rel='stylesheet' href='http://localhost:8080/router.php/res/css/login.css'>";

    public function __construct()
    {
        // session_start();
        if(!isset($_COOKIE["PHPSESSID"]))
        {
            session_start();
        }
    }

    public static function makeLogin():string {
        try{
            $result = BackendConx::getCall("http://localhost:1234/router.php/user/getUser");
            // Si el Usuario estaba logueado le llevamos a perfil
            // Donde se le cargaran los datos
            Navigate::redirect("perfil");
        } catch (Exception $e){
            $html = Header::makeHeader(); 
            $html = str_replace("##MdasLinksCss##",self::$linkSheet,$html);

            $login = file_get_contents(dirname(__FILE__)."/templates/login.html");
            $html = str_replace("##body##",$login,$html);
        }
        return $html;
    }
}
