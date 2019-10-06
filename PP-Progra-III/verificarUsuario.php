<?php
    require_once "Clases/usuario.php";
    $email = isset($_POST['email']) ? $_POST['email'] : NULL;
    $clave = isset($_POST['clave']) ? $_POST['clave'] : NULL;
    $email = str_replace(".", "_", $email);
    $usuario = new Usuario($email, $clave);

    if(Usuario::VerificarExistencia($usuario)){
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $date = date("d-m-y") . " - " . date("H:i:s");
        setcookie($email,$date);
        header("location: listadoUsuarios.php");
    }
    else{
        $retorno = new stdClass();
        $retorno->exito=false;
        $retorno->mensaje="El usuario no existe";
        echo json_encode($retorno);
    }
