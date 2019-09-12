<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Agregar productos</title>
</head>
<body>
    <form action="Administracion.php" method="post" enctype="multipart/form-data"> 
        <table>
            <tr>
                <td>Nombre:
                <input type="text" placeholder="Escriba el nombre" name="nombreTxt" id="nombteTxt"></td>
                <td rowspan=10>
                    <?php
                        include "Clases/Producto.php";

                        $array = array();
                        $array= Producto::TraerTodosLosProductos();
                        for ($i=0; $i < count($array); $i++) { 
                            if(isset($array[$i])){
                                echo "<img src='".$array[$i]->path."' width='10%'>";
                                echo $array[$i]->ToString();
                                echo "<br/>";
                            }          
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Codigo de barras:
                <input type="text" placeholder="Ingrese el codigo" name="codTxt" id="codTxt"></td>
            </tr>
            <tr>
                <td><input type="file" name="imagen" id="imagen"></td>
            </tr>
            <tr>
                <td>
                    <input type="submit" value="Agregar" name="op">

                </td>
            </tr>
        </table>        
    </form>
</body>
</html>