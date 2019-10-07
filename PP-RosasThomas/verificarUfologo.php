<?php
    require_once "Clases/ufologo.php";
    $legajo = isset($_POST['legajo']) ? $_POST['legajo'] : NULL;
    $clave = isset($_POST['clave']) ? $_POST['clave'] : NULL;
    $ufologo = new Ufologo(null, $legajo, $clave);
    $flag = Ufologo::VerificarExistencia($ufologo);
    if($flag->exito){
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $date = date("d-m-y") . " - " . date("H:i:s");
        $mensaje = $date." - ".$flag->mensaje;
        setcookie($legajo,$mensaje);
        header("location: listadoUfologos.php");
    }
    else{
        $retorno = new stdClass();
        $retorno->exito=false;
        $retorno->mensaje= $flag->mensaje;
        echo json_encode($retorno);
    }