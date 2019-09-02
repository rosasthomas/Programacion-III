<?php
include "Clases/Producto.php";

$prod = new Producto($_GET["nombre"], $_GET["codigo"]);

    switch($_GET["op"]){
        case "ALTA":
            if(Producto::Guardar($prod))
                echo "Se pudo guardar";
            else
                echo "No se pudo guardar";
        break;
        case "Mostrar":
            var_dump(Producto::TraerTodosLosProductos());
        break;
    }