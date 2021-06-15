<?php

namespace Foroupna\Controllers;

use Foroupna\Models\Session;
use Foroupna\Models\BackendConx;
use Exception;
use Foroupna\Models\Foro;
use Foroupna\Models\Navigate;

class ForoController
{
    public function __construct()
    {
        session_start();
        try {
            $_POST = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
        } catch (Exception $e) {
            // http_response_code(500);
        }
    }

    public function showForo($id_foro){
        if ($id_foro <= 0){
            http_response_code(400);
            return 'Erroren el id del foro';
        }

        $id_foro = Sanitizer::sanitize($id_foro);

        try {
            $forodata = BackendConx::getInstance()->getCall("foro/getforobyid/".$id_foro);
            // $comments = BackendConx::getInstance()->getCall("foro/getlastncomment/".$number);
            // $comments = "";//BackendConx::getInstance()->getCall("foro/getlastncomment/".$number);
            return Foro::makeForo($forodata);
        } catch (Exception $ex) {
            http_response_code(400);
            return $ex->getMessage();
        }
    }
}