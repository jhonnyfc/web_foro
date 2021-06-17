<?php

namespace Foroupna\Models;

class Session
{
    public static function loadSession(){
        $segundosDuracionSession = 800;
        ini_set('session.gc_maxlifetime', $segundosDuracionSession);
        session_set_cookie_params($segundosDuracionSession);
        session_start();

        $now = time();
        if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
            // this session has worn out its welcome; kill it and start a brand new one
            session_unset();
            session_destroy();
            session_start();
        }

        // either new or old, it should live at most for another hour
        $_SESSION['discard_after'] = $now + $segundosDuracionSession;
    }

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
