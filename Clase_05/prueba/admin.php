<?php
    $user = "root";
    $pass = "";
    try{
        $base = "mysql:host=localhost;dbname=mercado;charset=utf8";
        $pdo = new PDO($base, $user, $pass);
    }
    catch(PDOException $e){
        echo $e->messgae();
    }
   

    switch ($_POST["op"]) {
        case 'traerTodos_usuarios':           
            $sentence = $pdo->prepare("SELECT * FROM usuarios");
            $sentence->execute();
            $tabla = "<table border=2>
                        <tr>
                            <td>Id</td>
                            <td>Nombre</td>
                            <td>Apellido</td>
                            <td>Perfil</td>
                            <td>Estado</td>
                        </tr>";
            while($elementos = $sentence->fetch()){
                $tabla.="<tr> 
                                <td>".$elementos['id']."</td>
                                <td>".$elementos['nombre']."</td>
                                <td>".$elementos['apellido']."</td>
                                <td>".$elementos['perfil']."</td>
                                <td>".$elementos['estado']."</td>
                            </tr>";
            }
            $tabla.= "</table>";
            echo $tabla;   
            break;
        case 'traerPorId_usuarios':
            $id_usuario = $_POST["id_usuario"];
            echo "USUARIOS POR ID:<br\>";
            $sentence = $pdo->prepare("SELECT * FROM usuarios WHERE ID=:id");
            $sentence->execute(array(':id'=>$id_usuario));
            $tabla = "<table border=2>
            <tr>
                <td>Id</td>
                <td>Nombre</td>
                <td>Apellido</td>
                <td>Perfil</td>
                <td>Estado</td>
            </tr>";
            while($elementos = $sentence->fetch()){
               $tabla.="<tr> 
               <td>".$elementos['id']."</td>
               <td>".$elementos['nombre']."</td>
               <td>".$elementos['apellido']."</td>
               <td>".$elementos['perfil']."</td>
               <td>".$elementos['estado']."</td>
           </tr>";
            }         
            $tabla.= "</table>";
            echo $tabla; 
            break;
        case 'traerPorEstado_usuarios':
            $estado_usuario = $_POST["estado_usuario"];
            echo "USUARIOS POR ESTADO:<br\>";
            $sentence = $pdo->prepare("SELECT * FROM usuarios WHERE ESTADO=:estado");
            $sentence->execute(array(':estado'=>$estado_usuario));
            $tabla = "<table border=2>
            <tr>
                <td>Id</td>
                <td>Nombre</td>
                <td>Apellido</td>
                <td>Perfil</td>
                <td>Estado</td>
            </tr>";
            while($elementos = $sentence->fetch()){
               $tabla.="<tr> 
               <td>".$elementos['id']."</td>
               <td>".$elementos['nombre']."</td>
               <td>".$elementos['apellido']."</td>
               <td>".$elementos['perfil']."</td>
               <td>".$elementos['estado']."</td>
           </tr>";
            }         
            $tabla.= "</table>";
            echo $tabla; 
            break;
        case 'agregar_usuarios':
            $nombre_usuario = $_POST["nombre_usuario"];
            $apellido_usuario = $_POST["apellido_usuario"];
            $clave_usuario = $_POST["clave_usuario"];
            $perfil_usuario = $_POST["perfil_usuario"];
            $estado_usuario = $_POST["estado_usuario"];
            $sentence = $pdo->prepare("INSERT INTO usuarios (nombre,apellido,clave,perfil,estado,correo) 
            VALUES(:nombre, :apellido, :clave, :perfil, :estado, :correo)");
             $consulta->bindValue(':nombre', $nombre_usuario, PDO::PARAM_STR);
             $consulta->bindValue(':apellido', $apellido_usuario, PDO::PARAM_STR);
             $consulta->bindValue(':perfil', $clave_usuario, PDO::PARAM_INT);
             $consulta->bindValue(':estado', $estado_usuario, PDO::PARAM_INT);
             $consulta->bindValue(':clave', $correo_usuario, PDO::PARAM_STR);
             $consulta->bindValue(':correo', $clave_usuario, PDO::PARAM_STR);
 
            if($sentence->execute()){
                echo "Se agrego correctamente";
            }
            else{
                echo "No se pudo agregar";
            }
            break;
        case 'modificar_usuarios':
            $id_usuario = $_POST["id_usuario"];
            $nombre_usuario = $_POST["nombre_usuario"];
            $apellido_usuario = $_POST["apellido_usuario"];
            $clave_usuario = $_POST["clave_usuario"];
            $perfil_usuario = $_POST["perfil_usuario"];
            $estado_usuario = $_POST["estado_usuario"];
            $sentence = $pdo->prepare("UPDATE usuarios SET nombre=:nombre, apellido=:apellido, clave=:clave, 
                perfil=:perfil, estado=:estado, correo=:correo WHERE id=:id");
                $consulta->bindValue(':nombre', $nombre_usuario, PDO::PARAM_STR);
                $consulta->bindValue(':apellido', $apellido_usuario, PDO::PARAM_STR);
                $consulta->bindValue(':perfil', $clave_usuario, PDO::PARAM_INT);
                $consulta->bindValue(':estado', $estado_usuario, PDO::PARAM_INT);
                $consulta->bindValue(':clave', $correo_usuario, PDO::PARAM_STR);
                $consulta->bindValue(':correo', $clave_usuario, PDO::PARAM_STR);
             if($sentence->execute()){
                echo "Se modifico correctamente";
            }
            else{
                echo "No se pudo modificar";
            }
            break;
        case 'borrar_usuarios':
                $id_usuario = $_POST["id_usuario"];
                $sentence = $pdo->prepare("DELETE FROM usuarios WHERE id=:id");
                $consulta->bindValue(':id', $id_usuario, PDO::PARAM_INT);
                if($sentence->execute()){
                    echo "Se elimino correctamente";
                }
                else{
                    echo "No se pudo eliminar";
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
            $tabla = "<table border=2>
                        <tr>
                            <td>Id</td>
                            <td>Nombre</td>
                            <td>Codigo de Barra</td>
                            <td>Path</td>
                        </tr>";
            if(!$rs){
                $tabla.= "<tr>
                            No hay productos
                            </tr>";
            }
            else{
                for($i=0; $i<count($user_arr); $i++){
                    $tabla.="<tr> 
                                <td>".$user_arr[$i]->id."</td>
                                <td>".$user_arr[$i]->nombre."</td>
                                <td>".$user_arr[$i]->codigo_barra."</td>
                                <td>".$user_arr[$i]->path_foto."</td>
                            </tr>";
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