<?php

namespace Foroupna\Models;

use Exception;
use mysqli_sql_exception;
use PHPMD\Utility\Strings;



class Home
{
    private static $linkSheet = "<link rel='stylesheet' href='res/css/home.css'>";

    public function __construct()
    {
        // session_start();
        if(!isset($_COOKIE["PHPSESSID"]))
        {
            session_start();
        }
    }

    public static function makeHome():string {
        $html = Header::makeHeader(); 
        $html = str_replace("##MdasLinksCss##",self::$linkSheet,$html);

        $home = file_get_contents(dirname(__FILE__)."/templates/home.html");
        $html = str_replace("##body##",$home,$html);

        return $html;
    }
}
