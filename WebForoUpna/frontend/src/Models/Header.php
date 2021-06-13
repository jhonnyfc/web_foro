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
    public static $lniks = '<li><a href="registrar">Registar</a></li>
                            <li><a href="buscador">Buscar🔍</a></li>
                            <li><a href="login">Login</a></li>';

    public static $lniksLoged = '<li><a href="makeforo">Crear</a></li>
                            <li><a href="buscador">Buscar🔍</a></li>
                            <li><a href="perfil">Perfil</a></li>
                            <li><a onclick="logout()">LogOut</a></li>';

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
            $result = BackendConx::getInstance()->getCall("user/getUser");
            $header = str_replace("##LinksNavBar##",self::$lniksLoged,$header);
            // TODO
            // Habra que poner la fncion de cerrar session con los datos del usuario actual
        } catch (Exception $e){
            // echo $e->getMessage();
            $header = str_replace("##LinksNavBar##",self::$lniks,$header);
        }

        return  $header;
    }


}
