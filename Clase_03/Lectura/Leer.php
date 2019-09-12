<?php
$archivo = fopen("saludo.txt", "r");

while(!feof($archivo)){
    $cadena = fgets($archivo);
}
echo "<h2>".$cadena."</h2>";
/*
echo "<br/>Lectura con fread";
$lectura = fread($archivo, filesize("saludo.txt"));
fclose($archivo);

echo "<h2>".$lectura."</h2>";
*/ 