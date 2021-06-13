<?php

namespace Foroupna\Models;

use Exception;
use Foroupna\Models\Navigate;
use mysqli_sql_exception;
use PHPMD\Utility\Strings;



class Buscador
{
    private static $linkSheet = "<link rel='stylesheet' href='res/css/buscador.css'>";

    public function __construct()
    {
        // session_start();
        if(!isset($_COOKIE["PHPSESSID"]))
        {
            session_start();
        }
    }

    public static function makeBuscador():string {
        $html = Header::makeHeader(); 
        $html = str_replace("##MdasLinksCss##",self::$linkSheet,$html);

        $login = file_get_contents(dirname(__FILE__)."/templates/buscador.html");
        $html = str_replace("##body##",$login,$html);

        return $html;
    }
}
