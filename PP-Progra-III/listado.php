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
        <thead><tr><td>Tipo</td><td>Precio</td><td>Pais de origen</td> <td>Foto</td><td>Precio con IVA</td></tr></thead>
        <?php
            require_once "./clases/Televisor.php";
            $tele = new Televisor();
            $lista = $tele->Traer();
            $tabla = "";
            foreach($lista as $tv)
            {
                $tabla.= "<tr>
                            <td>" . $tv->tipo . "</td>
                             <td>" . $tv->precio . "</td>
                             <td>" . $tv->paisOrigen . "</td>";

                if($tv->path != null)
                {
                    $tabla .= "<td><img src='./televisores/imagenes/" . $tv->path . "'></td>";
                }
                else{
                    $tabla.= "<td></td>";
                }
                $tabla.= "<td>". $tv->CalcularIVA() ."</td>
                     </tr>";
            } 
            $tabla.= "</table>";
            echo $tabla;
        ?>
    </table>
</body>
</html>

