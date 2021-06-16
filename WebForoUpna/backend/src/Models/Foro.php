<?php

namespace Foroupna\Models;

use Exception;
use mysqli_sql_exception;
use phpDocumentor\Reflection\Types\Integer;

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
            $pathFoto = "http://localhost:1234/imgs/".$fotoname;
            $query = "UPDATE foro SET foto_url=? WHERE id_foro=?";

            $conn = Database::getInstance()->getConnection();
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss",$pathFoto,$fotoname);

            $stmt->execute();
            $stmt->close();

            return $fotoname;
        } catch (mysqli_sql_exception $ex) {
            throw $ex;
        }
    }

    public static function getMostComment($number){
        try {
            $query = "SELECT f.id_foro, f.titulo, f.foto_url
                    FROM foro f LEFT JOIN comment c ON f.id_foro = c.id_foro
                    GROUP BY f.id_foro
                    ORDER BY count(f.id_foro) DESC LIMIT ?";

            $conn = Database::getInstance()->getConnection();
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s",$number);

            $stmt->execute();
            $res = $stmt->get_result();
            $stmt->close();

            if ($res->num_rows < 0)
                return "";

            $data = array();
            while ($row = $res->fetch_assoc()) {
                $data[] = $row;
            }

            return $data;
        } catch (mysqli_sql_exception $ex) {
            throw $ex;
        }
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

    public static function buscaForo($titulo){
        try {
            $query = "SELECT *
                    FROM foro f
                    WHERE f.titulo LIKE '%?%'";

            $conn = Database::getInstance()->getConnection();
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s",$titulo);

            $stmt->execute();
            $res = $stmt->get_result();
            $stmt->close();

            $data = array();
            while ($row = $res->fetch_assoc()) {
                $data[] = $row;
            }

            return $data;
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

    public static function countNumRowsForo($titulo):Integer{
        try {
            $query = "SELECT count(f.id_foro) as num_filas
                    FROM foro f
                    WHERE f.titulo LIKE '%?%'";

            $conn = Database::getInstance()->getConnection();
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s",$titulo);

            $stmt->execute();
            $res = $stmt->get_result();
            $stmt->close();

            $row = $res->fetch_assoc();

            return $row["num_filas"];
        } catch (mysqli_sql_exception $ex) {
            throw $ex;
        }
    }

    public static function getCommentsByForoId($id_foro,$numRowXPag,$pagina){
        try {
            $query = "SELECT *
                    FROM comment c
                    WHERE c.id_foro = ?
                    ORDER BY c.idcom ASC LIMIT ?,?";

            $ini = (($pagina - 1) *  $numRowXPag );
            $end = ($numRowXPag);

            $conn = Database::getInstance()->getConnection();
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss",$id_foro,$ini,$end);

            $stmt->execute();
            $res = $stmt->get_result();
            $stmt->close();

            $data = array();
            while ($row = $res->fetch_assoc()) {
                $data[] = $row;
            }

            return $data;
        } catch (mysqli_sql_exception $ex) {
            throw $ex;
        }
    }

    public static function countNumRowsCommentForo($id_foro){
        try {
            $query = "SELECT count(c.idcom) as num_filas
                    FROM comment c
                    WHERE c.id_foro = ?
                    GROUP BY c.id_foro";

            $conn = Database::getInstance()->getConnection();
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s",$id_foro);

            $stmt->execute();
            $res = $stmt->get_result();
            $stmt->close();

            $row = $res->fetch_assoc();

            return $row["num_filas"];
        } catch (mysqli_sql_exception $ex) {
            throw $ex;
        }
    }

    public static function findForo($id_foro){
        try {
            $query = "SELECT *
                    FROM foro f
                    WHERE f.id_foro = ?";

            $conn = Database::getInstance()->getConnection();
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s",$id_foro);

            $stmt->execute();
            $res = $stmt->get_result();
            $stmt->close();

            $row = $res->fetch_assoc();
            return $row;
        } catch (mysqli_sql_exception $ex) {
            throw $ex;
        }
    }
}
