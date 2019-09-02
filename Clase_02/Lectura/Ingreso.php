<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Ingreso</title>   
    </head>
    <body>
        <form action="Escribir.php" method="get">
            <table>
                <tr><td><input type="text" value="Nombre" name=nombreTxt></td></tr>
                <tr><td><input type="text" value="Apellido" name=apellidoTxt></td></tr>
                <tr>
                <td><input type="submit" name="btnEnviar" value="Enviar"></td>
                <td><input type="reset" value="Limpiar" name="btnLimpiar"></td>
                </tr>
            </table>
        </form>
    </body>
</html>
