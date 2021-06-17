<?php

namespace Foroupna\Controllers;

use Foroupna\Models\Foro;
use Foroupna\Models\User;
use Exception;
use Foroupna\Models\Session;

class FileController
{
    public static function uploadFoto($dir,$fotoname,$nuevo_ancho,$nuevo_alto,$isPerfil) {
        $temp_file = $_FILES['file']['tmp_name'];
        // $location = $dir . $_FILES['file']['name'];
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

        if (strcmp($ext,"jpg") != 0 && strcmp($ext,"jpeg") != 0){
            throw new Exception("La foto debe de ser jpg o jpeg");
        }

        // echo $fotoname.".".$ext." <br> ".$_FILES['file']['name']." <br>";

        if (!$isPerfil)
            $res = Foro::updateFoto($fotoname.".".$ext);
        else {
            $res = User::updateFoto($fotoname.".".$ext,$fotoname);
        }

        $location = $dir.$res;

        header('Content-type: image/jpeg');
        $thumb = self::mo_resizeImage($temp_file,$nuevo_ancho,$nuevo_alto);

        // move_uploaded_file($thumb , $location);
        if (!imagejpeg($thumb , $location)){
            throw new Exception("Erro camibar redmimensioanar archivo");
        }

        return "Foto Subida Bien";
    }

    public static function mo_resizeImage($temp_file,$nuevo_ancho,$nuevo_alto){
        list($ancho, $alto) = getimagesize($temp_file);

        // Cargar
        $thumb = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);
        $origen = imagecreatefromjpeg($temp_file);

        // Cambiar el tamaño
        imagecopyresized($thumb, $origen, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);

        return $thumb;
    }
}