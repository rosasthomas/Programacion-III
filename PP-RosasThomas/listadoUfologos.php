<?php
    require_once "Clases/ufologo.php";

    $lista = Ufologo::TraerTodos();
    $cadena = array();
    foreach($lista as $ufologo)
    {
        array_push($cadena, $ufologo->toJSON());
    }

    echo json_encode($cadena);