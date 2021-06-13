<?php

namespace Foroupna\Models;

use Exception;
use mysqli_sql_exception;
use PHPMD\Utility\Strings;

// echo dirname(__FILE__);
// $aux = file_get_contents(dirname(__FILE__)."/header.html");
// echo $aux;

class Header
{
    public static $lniks = '<li><a href="">Registar</a></li>
                            <li><a href="">Buscar🔍</a></li>
                            <li><a href="">Login</a></li>';

    public static $lniksLoged = '<li><a href="">Crear</a></li>
                            <li><a href="">LogOut</a></li>
                            <li><a href="">Buscar🔍</a></li>
                            <li><a href="">Perfil</a></li>';

    public function __construct()
    {
        // session_start();
        if(!isset($_COOKIE["PHPSESSID"]))
        {
        session_start();
        }
    }

    public static function makeHeader():string {
        $header = file_get_contents(dirname(__FILE__)."/templates/header.html");

        try{
            $result = BackendConx::getCall("http://localhost:1234/router.php/user/getUser");
            // Si el Usuario esta logueado
            $header = str_replace("##LinksNavBar##",self::$lniks,$header);
        } catch (Exception $e){
            // Usuario no logueado
            $header = str_replace("##LinksNavBar##",self::$lniksLoged,$header);
        }

        return  $header;
    }


}
