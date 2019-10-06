<?php   
    require_once "./Clases/televisor.php";
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;
    $precio = isset($_POST['precio']) ? $_POST['precio'] : null;
    $pais = isset($_POST['pais']) ? $_POST['pais'] : null;
    $foto = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : null;
    $nombreFoto = $tipo . "." . $pais. "." . date("Gis") . ".jpeg";
    $ruta = "./televisores/imagenes/".$nombreFoto;
    if(move_uploaded_file($_FILES["foto"]["tmp_name"],$ruta)){
        $tele = new Televisor($tipo,$precio,$pais,$nombreFoto);
    }
    $json = new stdClass();
    if($tele->Modificar($id))
    {
        $json->exito = true;
        $json->mensaje = "Se agrego correctamente";
        header('location:listado.php');
    }
    else
    {
        $json->exito = false;
        $json->mensaje = "No se pudo modificar"; 
        echo json_encode($json);
    }