<?php

namespace Foroupna\Models;

class Session
{

    public static function put($key, $value): void
    {
        //session_start();
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        //session_start();
        return ($_SESSION[$key] ?? null);
    }

    public static function forget($key): void
    {
        //session_start();
        unset($_SESSION[$key]);
    }
}
