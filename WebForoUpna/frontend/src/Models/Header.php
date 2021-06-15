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
    public static $lniksNL = '<li><a href="##sp##registrar">Registar</a></li>
                            <li><a href="##sp##buscador">Buscar🔍</a></li>
                            <li><a href="##sp##login">Login</a></li>';

    public static $lniksLoged = "<li><a href='##sp##makeforo'>Crear</a></li>
                            <li><a href='##sp##buscador'>Buscar🔍</a></li>
                            <li><a href='##sp##perfil'>Perfil</a></li>
                            <li><a onclick=".'logout("##sp##")'.">LogOut</a></li>";

    public function __construct()
    {
    }

    public static function makeHeader($nav):string {
        $header = file_get_contents(dirname(__FILE__)."/templates/header.html");

        try{
            $result = BackendConx::getInstance()->getCall("user/getUser");
            $links = self::$lniksLoged;
        } catch (Exception $e){
            // echo $e->getMessage();
            $links = self::$lniksNL;
        }
        $header = str_replace("##LinksNavBar##",$links,$header);
        $header = str_replace("##sp##",$nav,$header);

        return  $header;
    }


}
