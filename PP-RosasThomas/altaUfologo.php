<?php
    require_once "Clases/ufologo.php";
    $pais = isset($_POST['pais']) ? $_POST['pais'] : NULL;
    $legajo = isset($_POST['legajo']) ? $_POST['legajo'] : NULL;
    $clave = isset($_POST['clave']) ? $_POST['clave'] : NULL;
    
    $ufologo = new Ufologo($pais, $legajo, $clave);
    $flag = new stdClass();
    $flag = $ufologo->GuardarEnArchivo();

    if($flag->exito){
        echo json_encode($flag);
    }
    else{
        echo json_encode($flag);
    }