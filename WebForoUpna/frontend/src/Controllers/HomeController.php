<?php

namespace Foroupna\Controllers;

use Foroupna\Models\Session;
use Foroupna\Models\BackendConx;
use Exception;
use Foroupna\Models\Home;
use Foroupna\Models\Navigate;

class HomeController
{
    public function __construct()
    {
        try {
            $_POST = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
        } catch (Exception $e) {
            // http_response_code(500);
        }
    }

    public function showHome(){
        try {
            $number = 3;
            $number2 = 4;
            $foros = BackendConx::getInstance()->getCall("foro/getmostcommet/".$number);
            $comments = BackendConx::getInstance()->getCall("foro/getlastncomment/".$number2);
            // $comments = "";//BackendConx::getInstance()->getCall("foro/getlastncomment/".$number);
            return Home::makeHome($foros,$comments);
        } catch (Exception $ex) {
            http_response_code(400);
            return $ex->getMessage();
        }
    }

    public static function redirect(): void
    {
        Navigate::redirect("home");
    }
}
