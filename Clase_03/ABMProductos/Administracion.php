<?php
include "Clases/Producto.php";
include "Clases/Imagen.php";
session_start();

$prod = new Producto($_POST["nombreTxt"], $_POST["codTxt"], Subir::validarTipo());

    switch($_POST["op"]){
        case "Agregar":      
            if(Producto::Guardar($prod))
            {
                 echo "Se pudo guardar";
                $_SESSION["clave"] = $prod->cod_barra;             
            }
            else{
                echo "No se pudo guardar";
            }
            header("location: index.php");
        break;
        case "Mostrar":
            $array = array();
                $array= Producto::TraerTodosLosProductos();
                for ($i=0; $i < count($array); $i++) { 
                    if(isset($array[$i])){
                        echo $array[$i]->ToString();
                        echo "<br/>";
                        echo "<img src='".$array[$i]->path."' width='10%'>";
                    }          
                }
        break;
    }