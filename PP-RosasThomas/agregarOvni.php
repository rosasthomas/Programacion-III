<?php
    require_once "./Clases/ovni.php";
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;
    $velocidad = isset($_POST['velocidad']) ? $_POST['velocidad'] : null;
    $planeta = isset($_POST['planetaOrigen']) ? $_POST['planetaOrigen'] : null;
    $foto = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : null;

    $nombreFoto = $tipo . "." . $planeta. "." . date("Gis") . ".jpg";

    $ovni = new Ovni($tipo, $velocidad, $planeta, $nombreFoto);
    $lista = $ovni->Traer();
    $json = new stdClass();
    $json->exito = false;

    if(!$ovni->Existe($lista)){
        $ruta = "./ovnis/imagenes/".$nombreFoto;
        if(move_uploaded_file($_FILES["foto"]["tmp_name"],$ruta)){
            if($ovni->Agregar()){
                $json->exito = true;
                $json->mensaje = "Se agrego correctamente";
                header('location: listado.php');
            }
            else{
                $json->mensaje = "No se pudo agregar";
                echo json_encode($json);
            }
        }
    }
    else{
        $json->mensaje = "No se pudo agregar";
        echo json_encode($json);
    }