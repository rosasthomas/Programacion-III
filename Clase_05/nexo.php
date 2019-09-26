<?php
include_once ("AccesoDatos.php");
include_once ("usuario.php");

    switch ($_POST['op']) {
        case 'existe':
            $usuario = json_decode($_POST["usuario"]);
            if(Usuario::existeEnBD($usuario->correo, $usuario->clave)){
                echo json_encode($usuario);
            }
            else{
                echo "No existe ese correo";
            }
        break;
        
        default:
            echo ":c";
        break;
    };