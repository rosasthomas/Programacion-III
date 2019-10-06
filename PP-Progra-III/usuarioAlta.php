<?php
    require_once "Clases/usuario.php";
    $email = isset($_POST['email']) ? $_POST['email'] : NULL;
    $clave = isset($_POST['clave']) ? $_POST['clave'] : NULL;

    $usuario = new Usuario($email, $clave);
    $flag = new stdClass();
    $flag = $usuario->GuardarEnArchivo();

    if($flag->exito){
        echo $flag->mensaje;
    }
    else{
        echo $flag->mensaje;
    }