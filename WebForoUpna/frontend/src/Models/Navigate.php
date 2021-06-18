<?php

namespace Foroupna\Models;

class Navigate
{
    public static function redirect($path): void
    {
        require_once __DIR__ . "/../config/config.php";
        
        $url = ORIGIN_NAME."/router.php/".$path;
        header("Location: $url");
    }
}
