<?php

namespace Foroupna\Models;

use Exception;
use mysqli_sql_exception;

// Para quitar los reportes de error  o wringis

class Foro
{
    public string $foto_url;
    public string $username;
    public string $email;

    public function __construct()
    {
    }

    public static function makeForo($titulo,$username,$descripcion): string{
        try {
            $query = "INSERT INTO foro(titulo, username, descripcion) VALUES ( ?, ?, ?)";

            $conn = Database::getInstance()->getConnection();
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $titulo, $username, $descripcion);

            $stmt->execute();
            $foroId = $stmt->insert_id;
            $stmt->close();

            return $foroId;
        } catch (mysqli_sql_exception $ex) {
            throw $ex;
        }
    }

    public static function updateFoto($fotoname){
        try {
            $query = "UPDATE foro SET foto_url=? WHERE id=?";

            $conn = Database::getInstance()->getConnection();
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss",$fotoname,$fotoname);

            $stmt->execute();
            $stmt->close();

            return $fotoname;
        } catch (mysqli_sql_exception $ex) {
            throw $ex;
        }
    }
}
