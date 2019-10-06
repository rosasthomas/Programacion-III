<?php
    require_once "./Clases/televisor.php";

    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;
    $precio = isset($_POST['precio']) ? $_POST['precio'] : null;
    $pais = isset($_POST['pais']) ? $_POST['pais'] : null;
    $foto = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : null;

    $nombreFoto = $tipo . "." . $pais. "." . date("Gis") . ".jpeg";

    $tele = new Televisor($tipo,$precio,$pais,$nombreFoto);
    $ruta = "./televisores/imagenes/".$nombreFoto;
    $json = new stdClass();
    $json->exito = false;
    
        if(move_uploaded_file($_FILES["foto"]["tmp_name"],$ruta))
        {
            if($tele->Agregar()){
                $json->exito = true;
                $json->mensaje = "Se agrego correctamente";
                header('location: listado.php');
            }
            else{
                $json->mensaje = "No se pudo agregar";
                echo json_encode($json);
            }
        }
        else
        {
            $json->mensaje = "No se pudo agregar";
            echo json_encode($json);
        }
    
