<?php   
    require_once "./Clases/televisor.php";
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;
    $precio = isset($_POST['precio']) ? $_POST['precio'] : null;
    $pais = isset($_POST['pais']) ? $_POST['pais'] : null;
    $foto = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : null;
    $tele = new Televisor($tipo,$precio,$pais,$foto);
    $json = new stdClass();
    if($tele->Modificar($id,$tipo,$precio,$pais,$foto))
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