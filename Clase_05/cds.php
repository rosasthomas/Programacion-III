<?php
class cds
{
    public $titulo;
    public $anio;
    public $interprete;

    public function mostrar():string{
        return "Titulo: ".$titulo." - Interprete: ".$interprete." - Anio: ".$anio; 
    }
}