<?php 

    function mo_conexionbasedatos() {
        try{
            return mysqli_connect("localhost", "root","", "maze_runer");
        }catch (Exception $t) {
            return False;
        }
    }

    function verificaCreaUser(){
        // No se ha enviado nada
        if (isset($_POST['username']) and isset($_POST['password']))
            return false;

        $nombre = $_POST['username'];
        $password = $_POST['password'];

        if (ctype_alnum ($nombre) and strlen($nombre) > 0 and strlen($nombre) < 20){
            if (ctype_alnum ($password) and strlen($password) > 0 and strlen($password) < 20){
                // Verficacion en la base de datos
                $bbdd = mo_conexionbasedatos();

                $queryTx = "SELECT * FROM usuario u WHERE u.unickname LIKE '$nombre';";
                $resu = $bbdd->query($queryTx);
                if ($resu-> num_rows == 1) {
                    // Como ya existe el usuario vrificamos que la contraseña es correcta
                    $row = $resu->fetch_array(MYSQLI_ASSOC);

                    if (password_verify($password, $row["upass"])) {
                            $_SESSION["id"] =  $nombre;
                        // Login hecho co exito
                        return 1;
                    } else
                        // Contraseña erronea  
                        return false;

                } else {
                    // Como el usuaio no exite comprobamos que el usuario no haya intieado jugar antes
                    // Para ell outlizamo su ip
                    $uerip = getUserIP();
                    $queryTx = "SELECT * FROM lastIp l WHERE u.l_ipNumber LIKE '$uerip';";
                    $resu = $bbdd->query($queryTx);
                    if ($resu-> num_rows == 1){
                        // El ip ya ha iniciado prviamnte comprobamos que haya sido mas de 7 minutos desde la utlima vez
                        $row = $resu->fetch_array(MYSQLI_ASSOC);

                        // Calculamos el tiempo transcurrido
                        $dateNow = new DateTime("now");
                        $dateIp = DateTime::createFromFormat ( "Y-m-d H:i:s",$row["l_horaUlti"]);
                        $minutos = abs($dateIp->getTimestamp() - $dateNow->getTimestamp()) / 60;
                        if ($minutos > 7) {
                            // Crear la nueva cuenta con los datos debido a que ha pasado mas de 7 minutos
                            // Acutalizar ultima conexion de ip
                            updateIPdate($uerip);
                        
                           return creaCtuenta($nombre,$password);
                        } else {
                            // mandar error de que ya ha creado cuneta hace menos de 7 minutos
                        }
                    } else {
                        // El ip no se ha registrado prviamente
                        // Crear la nueva cunta y guardar el ip
                        insertIPdate($uerip);
                        return creaCtuenta($nombre,$password);
                    }
                }
            }else
                // Contraseña no valida por el fomrato
                return false;
        } else
            // Nombre no valido por el formato
            return false;
    }

    function creaCtuenta($nombre,$pass){
        $bbdd = mo_conexionbasedatos();
        $passHass = password_hash($pass, PASSWORD_DEFAULT);
        $consulta = "INSERT INTO usuario ( unickname,upass) VALUES ('$nombre','$passHass');";
        if ($bbdd->query($consulta)){
            // Registrado correctamete
            return true;
        } else {
            // Error con la cnoexion de la base de datos
            return false;
        }
    }

    function updateIPdate($uerip){
        $dateNow = new DateTime("now");
        $bbdd = mo_conexionbasedatos();
        $updateTx = "UPDATE lastIp l SET l.l_horaUlti = '$dateNow->format('Y-m-d H:i:s')' WHERE l.l_ipNumber LIKE '$uerip';";
        if ($bbdd->query($updateTx)) {
            // Se ha actualizado corretamente la hora de la ip
            return true;
        } else {
            // Error en la conexion cnoal base de datos
            return false;
        }
    }

    function insertIPdate($uerip){
        $bbdd = mo_conexionbasedatos();
        $updateTx =  "INSERT INTO lastIp (l_ipNumber) VALUES ('$uerip');";
        if ($bbdd->query($updateTx)) {
            // Se ha actualizado corretamente la hora de la ip
            return true;
        } else {
            // Error en la conexion cnoal base de datos
            return false;
        }
    }

    function getUserIP() {
        $userIP =   '';
        if(isset($_SERVER['HTTP_CLIENT_IP'])){
            $userIP =   $_SERVER['HTTP_CLIENT_IP'];
        }elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $userIP =   $_SERVER['HTTP_X_FORWARDED_FOR'];
        }elseif(isset($_SERVER['HTTP_X_FORWARDED'])){
            $userIP =   $_SERVER['HTTP_X_FORWARDED'];
        }elseif(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])){
            $userIP =   $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        }elseif(isset($_SERVER['HTTP_FORWARDED_FOR'])){
            $userIP =   $_SERVER['HTTP_FORWARDED_FOR'];
        }elseif(isset($_SERVER['HTTP_FORWARDED'])){
            $userIP =   $_SERVER['HTTP_FORWARDED'];
        }elseif(isset($_SERVER['REMOTE_ADDR'])){
            $userIP =   $_SERVER['REMOTE_ADDR'];
        }else{
            $userIP =   'UNKNOWN';
        }
        return $userIP;
    }
?>