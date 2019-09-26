<?php
require_once 'cds.php';
    $user = 'root';
    $pass = '';
    $sql = 'mysql:host=localhost;dbname=cdcol;charset=utf8';
    try{
        $pdo = new PDO($sql,$user,$pass);
        $consulta = 'SELECT titel as titulo, jahl as anio, interpret as interprete  FROM cds';
        $datos = $pdo->query($consulta);

        if($datos != null){
            $row = $datos->fetchObject('cds');
            foreach($row as $datito){
                //echo $datito['titel']." - ".$datito['jahr']." - ".$datito['interpret']."</br>";
                echo $datito->mostrar();
            }
        }
        else{
            echo "Esta vacio";
        }
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }