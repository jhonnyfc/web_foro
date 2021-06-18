<?php

namespace Foroupna\Models;

use Exception;
use mysqli_sql_exception;
use phpDocumentor\Reflection\Types\Integer;
require_once __DIR__ . "/../config/config.php";

// Para quitar los reportes de error  o wringis

class Foro
{

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
            $pathFoto = "http://localhost:1234/imgs/foro/".$fotoname;
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

    public static function buscaForo($titulo,$numRowXPag,$pagina){
        try {
            $query = "SELECT *
                    FROM foro f
                    WHERE f.titulo LIKE '%".$titulo."%' LIMIT ?,?";

            $ini = (($pagina - 1) *  $numRowXPag );
            $end = ($numRowXPag);

            $conn = Database::getInstance()->getConnection();
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss",$ini,$end);

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

    public static function countNumRowsForo($titulo){
        try {
            $query = "SELECT count(f.id_foro) as num_filas
                    FROM foro f
                    WHERE f.titulo LIKE '%".$titulo."%'";

            $conn = Database::getInstance()->getConnection();
            $stmt = $conn->prepare($query);
            // $stmt->bind_param("s",$titulo);

            $stmt->execute();
            $res = $stmt->get_result();
            $stmt->close();

            $row = $res->fetch_assoc();

            if ($row["num_filas"] == null){
                return 0;
            }

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
            $query = "SELECT c.idcom
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

            // if ($row["num_filas"] == null){
            //     return 0;
            // }

            // return $row["num_filas"];
            return $res->num_rows;
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
