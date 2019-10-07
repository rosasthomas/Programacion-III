<?php
     require_once "./Clases/ovnis.php";
     $id = isset($_POST['id']) ? $_POST['id'] : null;
     $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;
     $velocidad = isset($_POST['velocidad']) ? $_POST['velocidad'] : null;
     $planeta = isset($_POST['planeta']) ? $_POST['planeta'] : null;
     $foto = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : null;
     $nombreFoto = $tipo . "." . $planeta. "." . date("Gis") . ".jpeg";
     $ruta = "./ovnis/imagenes/".$nombreFoto;


     if(move_uploaded_file($_FILES["foto"]["tmp_name"],$ruta)){
         $ovni = new Ovni($tipo,$velocidad,$planeta,$nombreFoto);
     }
     $json = new stdClass();
     if($ovni->Modificar($id))
     {
         $json->exito = true;
         $json->mensaje = "Se agrego correctamente";
         header('location:listadoUgologos.php');
     }
     else
     {
         $json->exito = false;
         $json->mensaje = "No se pudo modificar"; 
         echo json_encode($json);
     }