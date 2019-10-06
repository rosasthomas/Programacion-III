<?php
    $email = isset($_GET['email']) ? $_GET['email'] : NULL;
    $aux = str_replace(".","_",$email);
    $retorno = new stdClass();
    if(isset($_COOKIE[$aux])){
        $retorno->exito = true;
        $retorno->mensaje = $_COOKIE[$aux];
    }
    else{
        $retorno->exito = false;
        $retorno->mensaje = "No existe una cookie con ese nombre";
    }

    echo json_encode($retorno);