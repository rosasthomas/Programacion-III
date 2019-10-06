<?php
    require_once "./Clases/televisor.php";

    if(isset($_GET['tipo'])){
        $tele = new Televisor($_GET['tipo']);
        if($tele->Existe()){
            echo "El televisor se encuentra registrado";
        }
        else{
            echo "El televisor no se encuentra registrado";
        }
    }
    else if(isset($_POST['tipo']) && isset($_POST['accion']) == 'borrar'){
        $tele = new Televisor($_POST['tipo']);
        if($tele->Eliminar()){
            header("location:listado.php");
        }
        else{
            $json = new stdClass();
            $json->exito = false;
            $json->mensaje = "No se pudo borrar el televisor";
            echo json_encode($json);
        }
    }
    else{
        echo ":c";
    }