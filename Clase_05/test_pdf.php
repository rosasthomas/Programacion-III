<?php
    require_once "vendor/autoload.php";
    require_once "usuario.php";
    require_once "producto.php";

    function tablaUsarios(){
        $mpdf = new \Mpdf\mpdf();
        $usuarios = Usuario::TraerTodosLosUsuario();
    
        }
        $tabla = "<table border=2>
                            <tr>
                                <td>Id</td>
                                <td>Nombre</td>
                                <td>Apellido</td>
                                <td>Perfil</td>
                                <td>Estado</td>
                            </tr>";
        foreach($usuarios as $us){   
            $tabla.="<tr> 
            <td>".$us->id."</td>
            <td>".$us->nombre."</td>
            <td>".$us->apellido."</td>
            <td>".$us->perfil."</td>
            <td>".$us->estado."</td>
         </tr>";
            
        }
        $tabla.= "</table>";
        $mpdf->WriteHTML($tabla);
        $mpdf->Output();
    }

    function tablaProductos(){
        $mpdf = new \Mpdf\mpdf();
        $productos = Producto::TraerTodosLosProductos();
        $tabla = "<table border=2>
                            <tr>
                                <td>Codigo Barra</td>
                                <td>Nombre</td>
                                <td>Foto</td>
                            </tr>";
        foreach($productos as $prod){   
            $tabla.="<tr> 
            <td>".$prod->GetCodBarra()."</td>
            <td>".$prod->GetNombre()."</td>
            <td><img src='".$prod->GetPathFoto()."'></td>
         </tr>";
            
        }
        $tabla.= "</table>";
        $mpdf->WriteHTML($tabla);
        $mpdf->Output();
    }
 