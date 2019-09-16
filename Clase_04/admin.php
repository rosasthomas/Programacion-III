<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $base = "mercado";
    $con = @mysqli_connect($host, $user, $pass, $base);

    switch ($_POST["op"]) {
        case 'traerTodos_usuarios':
            echo "TODOS LOS USUARIOS:<br\>";
            $sql = "SELECT * FROM usuarios";
            $rs = $con->query($sql);
            while ($row = $rs->fetch_object()){
                $user_arr[] = $row;
            }       
            var_dump($user_arr); 
            break;
        case 'traerPorId_usuarios':
            $id_usuario = $_POST["id_usuario"];
            echo "USUARIOS POR ID:<br\>";
            $sql = "SELECT * FROM `usuarios` WHERE `id`=$id_usuario";
            $rs = $con->query($sql);
            while ($row = $rs->fetch_object()){
                $user_arr[] = $row;
            }       
            var_dump($user_arr);    
            break;
        case 'traerPorEstado_usuarios':
            $estado_usuario = $_POST["estado_usuario"];
            echo "USUARIOS POR ESTADO:<br\>";
            $sql = "SELECT * FROM `usuarios` WHERE `estado`=$estado_usuario;";
            $rs = $con->query($sql);
            while ($row = $rs->fetch_object()){
                $user_arr[] = $row;
            }       
            var_dump($user_arr);  
            break;
        case 'agregar_usuarios':
            $nombre_usuario = $_POST["nombre_usuario"];
            $apellido_usuario = $_POST["apellido_usuario"];
            $clave_usuario = $_POST["clave_usuario"];
            $perfil_usuario = $_POST["perfil_usuario"];
            $estado_usuario = $_POST["estado_usuario"];
            $sql = "INSERT INTO usuarios (nombre,apellido,clave,perfil,estado) 
                    VALUES('$nombre_usuario','$apellido_usuario','$clave_usuario','$perfil_usuario','$estado_usuario')";
            $rs = $con->query($sql);
            if(!$rs){
                echo "No se pudo agregar el usuario.";
            }
            else{
                echo "Se agrego el usuario.";
            }
            break;
        case 'modificar_usuarios':
            $id_usuario = $_POST["id_usuario"];
            $nombre_usuario = $_POST["nombre_usuario"];
            $apellido_usuario = $_POST["apellido_usuario"];
            $clave_usuario = $_POST["clave_usuario"];
            $perfil_usuario = $_POST["perfil_usuario"];
            $estado_usuario = $_POST["estado_usuario"];
            $sql = "UPDATE usuarios SET nombre='$nombre_usuario', apellido='$apellido_usuario', clave='$clave_usuario', 
                perfil='$perfil_usuario', estado='$estado_usuario' WHERE id=$id_usuario";
                $rs = $con->query($sql);
                if(!$rs){
                    echo "No se pudo modificar el usuario.";
                }
                else{
                    echo "Se modifico el usuario.";
                }
            break;
        case 'borrar_usuarios':
                $id_usuario = $_POST["id_usuario"];
                $sql = "DELETE FROM usuarios WHERE id='$id_usuario'";
                $rs = $con->query($sql);
                if(!$rs){
                    echo "No se pudo borrar el usuario.";
                }
                else{
                    echo "Se borro el usuario.";
                }
                break;
        //PRODUCTOS
        case 'traerTodos_productos':
            /*echo "TODOS LOS PRODUCTOS:<br\>";
            $sql = "SELECT * FROM productos";
            $rs = $con->query($sql);
            while ($row = $rs->fetch_object()){
                $user_arr[] = $row;
            }       
            var_dump($user_arr);*/
            $sql = "SELECT * FROM productos";
            $rs = $con->query($sql);
            while ($row = $rs->fetch_object()){
                $user_arr[] = $row;
            }       
            $tabla = "<table>
                        <tr>
                            <td>Id</td>
                            <td>Nombre</td>
                            <td>Codigo de Barra</td>
                            <td>Path</td>
                        <tr>";
            if(!$rs){
                $tabla.= "<tr>
                            No hay productos
                            </tr>";
            }
            else{
                foreach ($user_arr as $key => $value) {
                    # code...
                }
            }
            $tabla.= "</table>";
            echo $tabla;
            break;
        case 'traerPorId_productos':
            $id_producto = $_POST["id_producto"];
            echo "PRODUCTOS POR ID:<br\>";
            $sql = "SELECT * FROM `productos` WHERE `id`=$id_producto";
            $rs = $con->query($sql);
            while ($row = $rs->fetch_object()){
                $user_arr[] = $row;
            }       
            var_dump($user_arr);    
            break;
        case 'agregar_productos':
            $nombre_producto = $_POST["nombre_producto"];
            $codigo_producto = $_POST["codigo_producto"];
            $path_producto = $_POST["path_producto"];
            
            $sql = "INSERT INTO productos(codigo_barra, nombre, path_foto) VALUES ('$codigo_producto','$nombre_producto',
                    '$path_producto')";
            $rs = $con->query($sql);
            if(!$rs){
                echo "No se pudo agregar el producto.";
            }
            else{
                echo "Se agrego el producto.";
            }
            break;
        case 'modificar_productos':
            $id_producto = $_POST["id_producto"];
            $nombre_producto = $_POST["nombre_producto"];
            $codigo_producto = $_POST["codigo_producto"];
            $path_producto = $_POST["path_producto"];
            $sql = "UPDATE productos SET codigo_barra='$codigo_producto',nombre='$nombre_producto',
                    path_foto='$path_producto' WHERE id='$id_producto'";
                $rs = $con->query($sql);
                if(!$rs){
                    echo "No se pudo modificar el producto.";
                }
                else{
                    echo "Se modifico el producto.";
                }
            break;
        case 'borrar_productos':
                $id_producto = $_POST["id_producto"];
                $sql = "DELETE FROM productos WHERE id='$id_producto'";
                $rs = $con->query($sql);
                if(!$rs){
                    echo "No se pudo borrar el producto.";
                }
                else{
                    echo "Se borro el producto.";
                }
                break;
        
        default:
            echo ":c";
            break;
    }

    mysqli_close($con);