<?php
abstract class FiguraGeometrica{
protected $color;
protected $perimetro;
protected $superficie;

public function _construct(string $color, float $perimetro, float $superficie){
$this->color = $color;
$this->perimetro = $perimetro;
$this->superficie = $superficie;
}

public function GetColor(){
    return $this->color;
}
public function SetColor(string $color){
    $this->color = color;
}

public abstract function Dibujar();
protected abstract function CalcularDatos();

public function ToString(){
    return $this->color. " - " .$this->perimetro. " - " .$this->superficie;
}


}








?>