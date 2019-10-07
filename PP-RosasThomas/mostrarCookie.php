<?php
    $ufologo = json_decode(isset($_GET['ufologo']) ? $_GET['ufologo'] : NULL);
   // var_dump($ufologo);
    $legajo = $ufologo->legajo;
    //echo $ufologo->legajo;
    $retorno = new stdClass();
    //setcookie("2", "",time()-2);
    if(isset($_COOKIE[$legajo])){
        $retorno->exito = true;
        $retorno->mensaje = $_COOKIE[$legajo];
    }
    else{
        $retorno->exito = false;
        $retorno->mensaje = "No existe una cookie con ese legajo";
    }

    echo json_encode($retorno);