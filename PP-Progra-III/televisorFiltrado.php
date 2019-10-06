<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table border=2>
        <thead>
            <tr><td>Tipo</td><td>Precio</td><td>Pais de origen</td><td>Foto</td><td>IVA</td></tr>
        </thead>   
         <?php
            require_once "./Clases/televisor.php";
            $pais = isset($_POST['pais']) ? $_POST['pais'] : null;
            $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;

            $tele = new Televisor($tipo,null,$pais);

            $lista = $tele->Filtrar();

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
</body>
</html>