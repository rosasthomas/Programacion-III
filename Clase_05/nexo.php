<?php
include_once ("AccesoDatos.php");
include_once ("usuario.php");
var_dump($_POST['op']);
    switch ($_POST['op']) {
        case 'existe':
            $usuario = json_decode($_POST["usuario"]);
            $retorno = new stdClass();
            $retorno->existe=Usuario::TraerPorCorreoYClave($usuario->correo, $usuario->clave);
            echo json_encode($retorno);
        break;    
        case 'insertar':
            $aux = json_decode($_POST['usuario']);
            $usuario = new Usuario($aux);
            if($usuario->InsertarElUsuario()){
                echo "Se agrego";
            }
            else{
                echo "No se agrego";
            }
            
        break;  
        case 'subirFoto':
            $objRetorno = new stdClass();
            $objRetorno->Ok = false;

            $destino = "./fotos/" . date("Ymd_His") . ".jpg";
            
            if(move_uploaded_file($_FILES["foto"]["tmp_name"], $destino) ){
                $objRetorno->Ok = true;
                $objRetorno->Path = $destino;
            }

            echo json_encode($objRetorno);
        break;
        default:
            echo ":c";
        break;
    };