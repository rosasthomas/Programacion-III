<?php

class Producto{
    private $nombre;
    private $cod_barra;

    public function __construct($n=null, $c=null){
        if($n != null){
            $this->nombre = $n;
            $this->cod_barra = $c;
        }
    }

    public function ToString(){
        return $this->cod_barra." - ".$this->nombre."\r\n";
    }

    public static function Guardar($obj){
        $flag = false;
        $archivo = fopen("./Archivos/productos.txt", "a");        
        $cad = fwrite($archivo, $obj->ToString());
        fclose($archivo);
        if($cad > 0)
            $flag = true;
        return $flag;
    }

    public static function TraerTodosLosProductos(){
        $productos = array();
        $aux = array();
        $archivo = fopen($archivo, r);
        while(!feof($archivo)){
            $datos = fgets($archivo);
            $aux = explode(" - ");
            array_push($productos, new Producto($aux[0], $aux[1]));
        }
        return $productos;
    }
}