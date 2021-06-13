<?php

namespace Foroupna\Models;

class Navigate
{
    public static function redirect($path): void
    {
        $url = "http://localhost:8080/router.php/".$path;
        header("Location: $url");
    }
}
