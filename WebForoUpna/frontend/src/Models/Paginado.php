<?php

namespace Foroupna\Models;

use Exception;
use mysqli_sql_exception;
use PHPMD\Utility\Strings;



class Paginado
{
    public function __construct()
    {
    }

    public static function makePaginado($keyWord,$numPages,$pagNow):string {
        $tempPaginado = file_get_contents(dirname(__FILE__)."/templates/paginado.html");

        $html = "";
        $paginacion = explode("##partes##", $tempPaginado);

        if($numPages > 5){
            if ($pagNow - 2 <= 0){
                // $dif = $numPages - 2;
                // $ini = $pagNow - $dif;
                // $fin = $pagNow + (4 - $dif);
                $ini = 1;
                $fin = 5;
            }elseif ($numPages - $pagNow < 2){
                // $dif = $numPages - $pagNow;
                // $ini = $pagNow - (4 - $dif);
                // $fin = $numPages + $dif;
                $ini = $numPages - 4;
                $fin = $numPages;
            } else {
                $ini = $pagNow - 2;
                $fin = $pagNow + 2;
            }
            for ($i = $ini; $i <= $fin; $i++){
                if ($i == $pagNow){
                    $tempParte = $paginacion[2];
                    $tempParte = str_replace("##keyword##",  $keyWord, $tempParte);
                    $tempParte = str_replace("##pagToloadNow##", $pagNow, $tempParte);
                    $html .= $tempParte;
                } else {
                    $tempParte = $paginacion[1];
                    $tempParte = str_replace('##estado##',  '', $tempParte);
                    $tempParte = str_replace("##keyword##",   $keyWord, $tempParte);
                    $tempParte = str_replace("##pagtoload##", $i, $tempParte);
                    $html .= $tempParte;
                }
            }
        } else {
            for ($i = 1; $i <= $numPages; $i++){
                if ($i == $pagNow){
                    $tempParte = $paginacion[2];
                    $tempParte = str_replace("##keyword##",  $keyWord, $tempParte);
                    $tempParte = str_replace("##pagToloadNow##", $pagNow, $tempParte);
                    $html .= $tempParte;
                } else {
                    $tempParte = $paginacion[1];
                    $tempParte = str_replace('##estado##',  '', $tempParte);
                    $tempParte = str_replace("##keyword##",   $keyWord, $tempParte);
                    $tempParte = str_replace("##pagtoload##", $i, $tempParte);
                    $html .= $tempParte;
                }
            }
        }

        if ($numPages == 1 or $numPages == 0){
            $tempParte = $paginacion[0];
            $tempParte = str_replace('##estado##',  'disabled', $tempParte);
            $tempParte = str_replace("##keyword##",   $keyWord, $tempParte);
            $tempParte = str_replace('##pagToloadPrev##', ($pagNow - 1), $tempParte);
            $tempParte .= $html;
            $html = $tempParte;

            $tempParte = $paginacion[3];
            $tempParte = str_replace('##estado##',  'disabled', $tempParte);
            $tempParte = str_replace("##keyword##",   $keyWord, $tempParte);
            $tempParte = str_replace('##pagToloadNext##', ($pagNow + 1), $tempParte);
            $html .= $tempParte;
        }elseif ($pagNow == $numPages){
            $tempParte = $paginacion[0];
            $tempParte = str_replace('##estado##',  '', $tempParte);
            $tempParte = str_replace("##keyword##",   $keyWord, $tempParte);
            $tempParte = str_replace('##pagToloadPrev##', ($pagNow - 1), $tempParte);
            $tempParte .= $html;
            $html = $tempParte;

            $tempParte = $paginacion[3];
            $tempParte = str_replace('##estado##',  'disabled', $tempParte);
            $tempParte = str_replace("##keyword##",   $keyWord, $tempParte);
            $tempParte = str_replace('##pagToloadNext##', ($pagNow + 1), $tempParte);
            $html .= $tempParte;
        } elseif ($pagNow == 1){

            $tempParte = $paginacion[0];
            $tempParte = str_replace('##estado##',  'disabled', $tempParte);
            $tempParte = str_replace("##keyword##",   $keyWord, $tempParte);
            $tempParte = str_replace('##pagToloadPrev##', ($pagNow - 1), $tempParte);
            $tempParte .= $html;
            $html = $tempParte;

            $tempParte = $paginacion[3];
            $tempParte = str_replace('##estado##',  '', $tempParte);
            $tempParte = str_replace("##keyword##",   $keyWord, $tempParte);
            $tempParte = str_replace('##pagToloadNext##', ($pagNow + 1), $tempParte);
            $html .= $tempParte;
        } else {
            $tempParte = $paginacion[0];
            $tempParte = str_replace('##estado##',  '', $tempParte);
            $tempParte = str_replace("##keyword##",   $keyWord, $tempParte);
            $tempParte = str_replace('##pagToloadPrev##', ($pagNow - 1), $tempParte);
            $tempParte .= $html;
            $html = $tempParte;

            $tempParte = $paginacion[3];
            $tempParte = str_replace('##estado##',  '', $tempParte);
            $tempParte = str_replace("##keyword##",   $keyWord, $tempParte);
            $tempParte = str_replace('##pagToloadNext##', ($pagNow + 1), $tempParte);
            $html .= $tempParte;
        }

        return $html;
    }
}
