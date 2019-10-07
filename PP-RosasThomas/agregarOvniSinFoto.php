<?php
    require_once "./Clases/ovni.php";

    $obj = json_decode(isset($_POST['ovni']) ? $_POST['ovni'] : NULL);

    $ovni = new Ovni($obj->tipo, $obj->velocidad, $obj->planetaOrigen);
    $json = new stdClass();

    if($ovni->Agregar())
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