<?php
    require_once "./Clases/televisor.php";

    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : NULL;
    $precio = isset($_POST['precio']) ? $_POST['precio'] : NULL;
    $paisOrigen = isset($_POST['pais']) ? $_POST['pais'] : NULL;

    $json = new stdClass();
    $tele = new Televisor($tipo, $precio, $paisOrigen);
    if($tele->Agregar())
    {
        $json->exito = true;
        $json->mensaje = "Se agrego correctamente";
        echo json_encode($json);
    }
    else
    {
        $json->exito = false;
        $json->mensaje = "No se pudo agregar";
        echo json_encode($json);
    }