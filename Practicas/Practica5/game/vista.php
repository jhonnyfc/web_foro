<?php 
    function mostarJuego(){
        $view = file_get_contents("eje9.html");
        $view = str_replace('#nombreGamer#',$_SESSION["id"], $view);
        $view = str_replace('#Puntuacion#',0, $view);
        echo $view;
        // aqui vamos a cmabiar el nombre eimplematar el chat 
    }

    function mostarInicio(){
        $view = file_get_contents("login.html");
        echo $view;
        // aqui vamos a cmabiar el nombre eimplematar el chat
        //echo getUserIP(); 
    }

    function crearMensajes($data){
        $data = $data[1];
        $res = array();

        $mesajesAux = file_get_contents("temp_msg.html");

        $aux = "";

        $allMsg = "";

        while ($fila = $data->fetch_assoc()) {
            $aux = str_replace('#miMensaje#', $fila['contenido'], $mesajesAux);
            $aux = str_replace('#miNombre#', $fila['unickname'], $aux);
            $allMsg .= $aux;
        }; 

        $res[0] = "1";
        $res[1] = $allMsg;
        echo json_encode($res);
    }

    function mostarJuegoLevel($puntua){
        $view = file_get_contents("eje9.html");
        $view = str_replace('#nombreGamer#',$_SESSION["id"], $view);
        $view = str_replace('#Puntuacion#',$puntua, $view);
        echo $view;
        // aqui vamos a cmabiar el nombre eimplematar el chat 
    }
?>