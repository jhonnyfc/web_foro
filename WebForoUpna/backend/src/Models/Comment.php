<?php

namespace Foroupna\Models;

use Exception;
use mysqli_sql_exception;
use phpDocumentor\Reflection\Types\Integer;

// Para quitar los reportes de error  o wringis

class Comment
{

    public function __construct()
    {
    }

    public static function insertComment($comentario,$id_foro,$username){
        try {
            $query = "INSERT INTO comment(comentario, id_foro, username) VALUES ( ?, ?, ?)";

            $conn = Database::getInstance()->getConnection();
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss",$comentario,$id_foro,$username);

            $stmt->execute();
            $stmt->close();
            
            return "Comentario creado correctamente";
        } catch (mysqli_sql_exception $ex) {
            throw $ex;
        }
    }

    public static function getLastNcomment($number){
        try {
            $query = "SELECT *
                    FROM comment c
                    ORDER BY c.idcom DESC LIMIT ?";

            $conn = Database::getInstance()->getConnection();
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s",$number);

            $stmt->execute();
            $res = $stmt->get_result();
            $stmt->close();

            // if ($res->num_rows < 0)
            //     return "";

            $data = array();
            while ($row = $res->fetch_assoc()) {
                $data[] = $row;
            }

            return $data;
        } catch (mysqli_sql_exception $ex) {
            throw $ex;
        }
    }
}
