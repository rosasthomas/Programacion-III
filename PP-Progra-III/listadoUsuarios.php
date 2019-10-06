<?php
    require_once "Clases/usuario.php";

    $lista = Usuario::TraerTodos();
    $cadena = "";
    foreach($lista as $usuario)
    {
        $cadena .= $usuario->toJSON() . "</br>";
    }

    echo $cadena;