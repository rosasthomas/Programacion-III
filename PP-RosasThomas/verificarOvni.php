<?php
    require_once "./Clases/ovni.php";

    $obj = json_decode(isset($_POST['ovni']) ? $_POST['ovni'] : NULL);

    $ovni = new Ovni($obj->tipo, $obj->velocidad, $obj->planetaOrigen);

    $lista = $ovni->Traer();
    $retorno = "No existe el ovni";
    if($ovni->Existe($lista)){
        $retorno = $ovni->ToJSON();
    }

    echo $retorno;