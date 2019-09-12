<?php
/*
$archivo = fopen("saludo.txt", "w");
$flag = fwrite($archivo, "Hola mundo!");
$flag = fwrite($archivo, "<br/>Thomas");
$flag = fwrite($archivo, "<br/>Rosas");
fclose($archivo);
if($flag > 0){
    echo "Se escribio correctamente";
}
*/
echo "GET<br/>";
var_dump($_GET);
echo "<br/>";

$datos = fopen("datos.txt", "w");
$flag = fwrite($datos, $_GET["nombreTxt"]);
$flag = fwrite($datos, "\n");
$flag = fwrite($datos, $_GET["apellidoTxt"]);
fclose($datos);

if($flag > 0){
    echo "Se escribio correctamente";
}