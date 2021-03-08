<?php
    session_start();
    include "modelo.php";
    include "vista.php";
    
    if (!isset($_GET["accion"]) and !isset($_POST["accion"])) {
		$accion = "show_board";
		$id = 1;
	} else{
        if (isset($_GET["id"])) {
            $id = $_GET["id"];	
        } elseif (isset($_POST["id"])) {
            $id = $_POST["id"];
        }

        if (isset($_GET["accion"])) {
            $accion = $_GET["accion"];	
        } elseif (isset($_POST["accion"])) {
            $accion = $_POST["accion"];
        }
    }

    /*if (!mo_SessionActive($accion)){
        $accion = "ini_sesi";
        $id = 1;
    }*/

    switch ($accion) {
        case "show_board":
            switch ($id) {
                case '1':# mostrar inicio sesion por primer vez;
                    mostarInicio();
                    break;
            }
        break;
        case "iniciar":
            switch ($id) {
                case '1':# mostrar inicio sesion por primer vez
                    $res = verificaCreaUser();
                    if ($res){
                        mostarJuego();
                    } else {
                        // Error al iniar la comprobaion de los datos
                        echo "bad";
                    }
                    break;
                case "2":
                    mostarJuegoLevel(leeLevl());
                    break;
            }
        break;
        case "chat":
            switch ($id) {
                case '1':# mostrar inicio sesion por primer vez
                    $cosas = meteMensaje();
                    if ($cosas[0] == "1")
                        crearMensajes($cosas);
                    else{
                        $res = array();
                        $res[0] = "0";
                        $res[1] = "datos no mal";
                        echo json_encode($res);
                    }
                break;
                case '2':# mostrar inicio sesion por primer vez
                    $cosas = get5Mensajes();
                    if ($cosas != false)
                        crearMensajes($cosas);
                    else{
                        $res = array();
                        $res[0] = "0";
                        $res[1] = "datos no mal";
                        echo json_encode($res);
                    }
                break;
            }
        break;
    }

?>