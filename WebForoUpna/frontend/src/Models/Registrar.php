<?php

namespace Foroupna\Models;

use Exception;
use Foroupna\Models\Navigate;
use mysqli_sql_exception;
use PHPMD\Utility\Strings;



class Registrar
{
    private static $linkSheet = "<link rel='stylesheet' href='res/css/registrar.css'>";
    private static $linkScript = "<script src='res/js/registrar.js'></script>";

    public function __construct()
    {
    }

    public static function makeRegistrar():string {
        $html = Header::makeHeader(""); 
        $librerias = self::$linkSheet.self::$linkScript;
        $html = str_replace("##MdasLinksCss##",$librerias,$html);

        $login = file_get_contents(dirname(__FILE__)."/templates/registrar.html");
        $html = str_replace("##body##",$login,$html);

        return $html;
    }
}
