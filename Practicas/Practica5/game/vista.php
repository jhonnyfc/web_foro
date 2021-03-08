<?php 
    function mostarJuego(){
        $view = file_get_contents("eje9.html");
        echo $view;
        // aqui vamos a cmabiar el nombre eimplematar el chat 
    }

    function mostarInicio(){
        $view = file_get_contents("login.html");
        echo $view;
        // aqui vamos a cmabiar el nombre eimplematar el chat
        //echo getUserIP(); 
    }
?>