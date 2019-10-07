<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lista de Televisores</title>
</head>
<body>
    <table border=2>
        <thead><tr><td>Tipo</td><td>Velocidad</td><td>Planeta de origen</td> <td>Foto</td><td>Velocidad Warp</td></tr></thead>
        <?php
            require_once "./clases/ovni.php";
            $ovni = new Ovni();
            $lista = $ovni->Traer();
            $tabla = "";
            foreach($lista as $obj)
            {
                $tabla.= "<tr>
                            <td>" . $obj->tipo . "</td>
                             <td>" . $obj->velocidad . "</td>
                             <td>" . $obj->planetaOrigen . "</td>";

                if($obj->pathFoto != null)
                {
                    $tabla .= "<td><img src='./ovnis/imagenes/" . $obj->pathFoto . "' width=40></td>";
                }
                else{
                    $tabla.= "<td></td>";
                }
                $tabla.= "<td>". $obj->ActivarVelocidadWarp() ."</td>
                     </tr>";
            } 
            $tabla.= "</table>";
            echo $tabla;
        ?>
    </table>
</body>
</html>
